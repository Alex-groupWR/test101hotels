$(document).ready(function() {
    // Установка текущей даты по умолчанию
    const now = new Date();
    const formattedDate = now.toISOString().slice(0, 10)
    $('#date').val(formattedDate);

    // Обработка сортировки
    $('#sort, #order').change(function() {
        loadComments();
    });

    // Обработка пагинации
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        loadComments($(this).data('page'));
    });

    // Добавление комментария
    $('#comment-form').submit(function(e) {
        e.preventDefault();

        // Сброс ошибок
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: 'api/comments/add',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#comment-form')[0].reset();
                    $('#date').val(formattedDate);

                    // Загружаем комментарии и обновляем пагинацию
                    loadComments().then(function() {
                        // Прокрутка к списку комментариев
                        $('html, body').animate({
                            scrollTop: $('#comments-list').offset().top - 20
                        }, 500);

                        // Если есть пагинация (более 3 комментариев), показываем ее
                        if ($('.pagination').length) {
                            $('.pagination').show();
                        }
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}-error`).text(errors[field]);
                    }
                } else {
                    alert('Произошла ошибка при отправке комментария');
                }
            }
        });
    });

    // Удаление комментария
    $(document).on('click', '.delete-comment', function() {
        const commentId = $(this).closest('.comment-card').data('id');

        if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
            $.ajax({
                url: `api/comments/delete/${commentId}`,
                type: 'DELETE',
                dataType: 'json',
                success: function() {
                    loadComments();
                },
                error: function() {
                    alert('Произошла ошибка при удалении комментария');
                }
            });
        }
    });

    // Функция загрузки комментариев
    function loadComments(page = 1) {
        const sort = $('#sort').val();
        const order = $('#order').val();

        return $.ajax({
            url: '/comments',
            type: 'GET',
            data: { page, sort, order },
            success: function(response) {
                $('#comments-list').html($(response).find('#comments-list').html());

                // Обновляем пагинацию
                const paginationHtml = $(response).find('.pagination').html();
                if (paginationHtml) {
                    $('.pagination').html(paginationHtml).show();
                } else {
                    $('.pagination').hide();
                }
            },
            error: function() {
                alert('Произошла ошибка при загрузке комментариев');
            }
        });
    }
});