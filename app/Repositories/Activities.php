<?php

namespace App\Repositories;

use Exception;

class Activities
{
    // Envia de notifacion a los usuarios con su mensaje de suma de puntos
    public function sendNotification($ids, $message, $title = 'Suma de puntos')
    {
        try {
            $fields = array(
                'to' => $ids,
                'notification' =>
                array(
                    'title' => $title,
                    'body' => $message
                ),
                "priority" => "high",
                "sound" => "default",
            );
            $headers = array('Authorization: key=AAAAbo_VXBc:APA91bF5ZReW0fiq3j4SVzTRKz-NaiZ7v_miKOeB9qt1nE4Y8QEpdCVNOsZCl_ggpCzZ66kDHCi0yBzx59ey1MoQP4wHxKGewQdBmVVQnRcdqhZXdkbgHN9J3VIFFqrTDFm9TQRSWDzY', 'Content-Type: application/json');
            $url = 'https://fcm.googleapis.com/fcm/send';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            // return json_decode($result, true);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
