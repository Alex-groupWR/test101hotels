<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\API\ResponseTrait;
use Carbon\Carbon;

class Comments extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new CommentModel();

        // Получаем параметры
        $page = $this->request->getVar('page') ?? 1;
        $sort = $this->request->getVar('sort') ?? 'id';
        $order = $this->request->getVar('order') ?? 'desc';

        $data = [
            'comments' => $model->getComments($page, 3, $sort, $order),
            'pager' => [
                'currentPage' => $page,
                'totalPages' => ceil($model->getTotalComments() / 3),
            ],
            'sort' => $sort,
            'order' => $order,
            'showPagination' => $model->getTotalComments() > 3
        ];

        return view('comments', $data);
    }

    public function addComment()
    {
        $model = new CommentModel();

        $data = [
            'name' => $this->request->getVar('name'),
            'text' => $this->request->getVar('text'),
            'date' => Carbon::parse($this->request->getVar('date'))->format('Y-m-d H:i'),
        ];

        // Используем валидацию из модели
        if (!$model->validate($data)) {
            return $this->respond([
                'status' => 'error',
                'errors' => $model->errors()
            ], 400);
        }

        $model->save($data);

        return $this->respond([
            'status' => 'success',
            'message' => 'Комментарий успешно добавлен'
        ], 200);
    }

    public function deleteComment($id)
    {
        $model = new CommentModel();

        if (!$model->find($id)) {
            return $this->failNotFound('Комментарий не найден');
        }

        $model->delete($id);

        return $this->respond([
            'status' => 'success',
            'message' => 'Комментарий удален'
        ], 200);
    }
}