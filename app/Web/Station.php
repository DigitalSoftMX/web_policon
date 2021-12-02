<?php

namespace App\Web;

use App\Point;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'station';

    protected $fillable = ['name', 'address', 'phone', 'email', 'number_station', 'active', 'image'];
    // Conexion con las ventas
    public function sales()
    {
        return $this->hasMany(DispatcherHistoryPayment::class);
    }
    // Relacion con las ventas por qr
    public function qrs()
    {
        return $this->hasMany(SalesQr::class);
    }
    // Realacion con los depositos de los clientes
    public function deposits()
    {
        return $this->hasMany(UserHistoryDeposit::class);
    }
    // Relacion con los rangos de vales
    public function ranges()
    {
        return $this->hasMany(CountVoucher::class, 'id_station', 'id');
    }
    // Relacion con los vales
    function vouchers()
    {
        return $this->hasMany(Voucher::class, 'id_station', 'id');
    }
    // Relacion con los canjes solicitados
    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
    // Relacion con los puntos del cliente
    public function puntos()
    {
        return $this->hasMany(Point::class);
    }
}
