<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                        cellspacing="0" width="100%" id="datatable_{{ $id }}">
                        <thead class="text-primary text-center">
                            <th>{{ __('Nombre') }}</th>
                            <th>{{ __('Membresía') }}</th>
                            <th>{{ __('Puntos') }}</th>
                            <th>{{ __('Acciones') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($winners[$station->number_station]['clients'] as $client)
                                <tr class="text-center">
                                    <td>
                                        {{ "{$client->user->name} {$client->user->first_surname} {$client->user->second_surname}" }}
                                    </td>
                                    <td>{{ $client->user->membership }}</td>
                                    <td>
                                        {{ $client->puntos->where('station_id', $station->id)->first()->points }}
                                    </td>
                                    <td>
                                        @if (!$currentPeriod->finish)
                                            <a href="{{ route('clients.points', $client) }}"
                                                class="btn btn-blue btn-sm">{{ __('Movimientos') }}
                                            </a>
                                        @else
                                            @if (!$currentPeriod->winner or !$station->winner)
                                                <form
                                                    action="{{ route('selectwinner', [$client, $station->number_station]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" title="Elegir como ganador"
                                                        class="btn btn-blue btn-sm">{{ __('Ganador') }}
                                                    </button>
                                                </form>
                                            @else
                                                @if ($client->winner)
                                                    <a rel="tooltip" class="btn btn-primary btn-link"
                                                        href="{{ route('clients.edit', $client->user) }}"
                                                        title="Ver el cliente">
                                                        <i class="fas fa-exclamation-circle"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-blue btn-sm" disabled>
                                                        {{ __('Ganador') }}
                                                    </button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
