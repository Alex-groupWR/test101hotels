<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система комментариев</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/comments.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-4 mb-5">
    <h1 class="mb-4 text-center">Комментарии</h1>

    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Сортировать по:</span>
                </div>
                <select class="form-control" id="sort">
                    <option value="date" <?= $sort == 'date' ? 'selected' : '' ?>>Дате</option>
                    <option value="id" <?= $sort == 'id' ? 'selected' : '' ?>>ID</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Направление:</span>
                </div>
                <select class="form-control" id="order">
                    <option value="desc" <?= $order == 'desc' ? 'selected' : '' ?>>По убыванию</option>
                    <option value="asc" <?= $order == 'asc' ? 'selected' : '' ?>>По возрастанию</option>
                </select>
            </div>
        </div>
    </div>

    <div id="comments-list" class="mb-4">
        <?php if (empty($comments)): ?>
            <div class="alert alert-info">Пока нет комментариев. Будьте первым!</div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="card mb-3 comment-card" data-id="<?= $comment['id'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-subtitle mb-2 text-primary"><?= esc($comment['name']) ?></h6>
                                <p class="card-text"><?= esc($comment['text']) ?></p>
                                <small class="text-muted"><?= esc($comment['date']) ?></small>
                            </div>
                            <button class="btn btn-sm btn-outline-danger delete-comment" title="Удалить">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($showPagination): ?>
        <nav aria-label="Page navigation" class="mb-5">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $pager['totalPages']; $i++): ?>
                    <li class="page-item <?= $i == $pager['currentPage'] ? 'active' : '' ?>">
                        <a class="page-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Добавить комментарий</h5>
        </div>
        <div class="card-body">
            <form id="comment-form">
                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" class="form-control" id="name" name="name" required placeholder="Введите ваш email">
                    <div class="invalid-feedback" id="name-error"></div>
                </div>
                <div class="form-group">
                    <label for="text">Комментарий</label>
                    <textarea class="form-control" id="text" name="text" rows="3" required placeholder="Введите ваш комментарий"></textarea>
                    <div class="invalid-feedback" id="text-error"></div>
                </div>
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input type="datetime-local" class="form-control" id="date" name="date" required>
                    <div class="invalid-feedback" id="date-error"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Отправить</button>
            </form>
        </div>
    </div>
</div>

<script src="/js/comments.js"></script>
</body>
</html>