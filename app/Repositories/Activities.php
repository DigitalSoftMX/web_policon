<?php

namespace App\Repositories;

use DateTime;
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
    // Lista de meses en español
    public function getNameMonthSpanish($date)
    {
        $date = date('m', strtotime($date));
        $months = [
            '01' => ['Ene', 'Enero'], '02' => ['Feb', 'Febrero'], '03' => ['Mar', 'Marzo'], '04' => ['Abr', 'Abril'],
            '05' => ['May', 'Mayo'], '06' => ['Jun', 'Junio'], '07' => ['Jul', 'Julio'], '08' => ['Ago', 'Agosto'],
            '09' => ['Sep', 'Septiembre'], '10' => ['Oct', 'Octubre'], '11' => ['Nov', 'Noviembre'],
            '12' => ['Dic', 'Diciembre'],
        ];
        return $months[$date];
    }
}
