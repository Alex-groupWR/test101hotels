<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'text', 'date'];

    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'name' => 'required|valid_email|max_length[255]',
        'text'  => 'required|min_length[5]',
        'date'  => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Email обязателен',
            'valid_email' => 'Введите корректный email'
        ],
        'text' => [
            'required' => 'Текст комментария обязателен',
            'min_length' => 'Комментарий должен содержать минимум 5 символов'
        ],
        'date' => [
            'required' => 'Дата обязательна к заполнению'
        ]
    ];

    public function getComments($page = 1, $perPage = 3, $sort = 'id', $order = 'desc')
    {
        $offset = ($page - 1) * $perPage;

        return $this->orderBy($sort, $order)
            ->findAll($perPage, $offset);
    }

    public function getTotalComments()
    {
        return $this->countAll();
    }
}
