<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationAPI extends BaseController
{
    public function getNotifications()
    {
        $notifModel = new NotificationModel();
        
        // Ambil notifikasi yang belum dibaca (unread), diurutkan terbaru
        $notifications = $notifModel
            ->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $notifications,
            'count' => count($notifications)
        ]);
    }

    public function markAsRead()
    {
        $notifModel = new NotificationModel();
        $id_notif = $this->request->getPost('id_notif');

        if (!$id_notif) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID notifikasi tidak ditemukan'
            ]);
        }

        $notifModel->update($id_notif, ['status' => 'read']);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Notifikasi sudah dibaca'
        ]);
    }

    public function markAllAsRead()
    {
        $notifModel = new NotificationModel();
        
        $notifModel->updateBatch(
            $notifModel->where('status', 'unread')->findAll(),
            'status'
        );

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Semua notifikasi sudah dibaca'
        ]);
    }
}
