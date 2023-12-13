@extends('adminlte::page')

@section('title', 'Solicitar turno')

@section('content_header')

@stop

@section('content')

    <div class="card card-dark mt-3">
        <div class="card-header">
            <h1 class="card-title">Confirmación de nuevo turno</h1>
        </div>
        <div class="card-body">
            <h3 class="text-center">¡Bienvenido, {{$pacienteTurnoNuevo->user->name}}! </h3>

            <div class="alert alert-warning mt-3 text-center" role="alert">
                Está viendo esta información porque detectamos la posibilidad de adelantar su turno.
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    <table class="table table-striped text-center" id="turnos">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    Turno Anterior
                                </th>
                            </tr>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                        </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $turnoAdelantado->fecha }}</td>
                                    <td>{{ $turnoAdelantado->hora }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-striped text-center" id="turnos">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    Turno Nuevo
                                </th>
                            </tr>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $turnoCancelado->fecha }}</td>
                                    <td>{{ $turnoCancelado->hora }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <h5 class="text-center">¿Desea confirmar el nuevo turno?</h5>

                <div class="alert alert-warning mt-3 text-center" role="alert">
                    Si <strong>rechaza</strong> el turno nuevo mantendrá reservado el turno anterior. <br>
                    Si <strong>confirma</strong> el turno nuevo, se cambiará la fecha del turno de la fecha anterior a la fecha del turno nuevo.
                </div>
            </div>

            <div class="row text-center">
                <div class="col-lg-6 mt-3">
                    <form id="form-confirmar" method="POST" action="{{ route('confirmar-adelantamiento-turno', $turnoTemporal->id) }}">
                        @csrf
                        <button class="btn btn-success confirmar-button" type="button">Confirmar adelantamiento de turno</button>
                    </form>
                </div>

                <div class="col-lg-6 mt-3">
                    <form id="form-rechazar" method="POST" action="{{ route('rechazar-adelantamiento-turno', $turnoTemporal->id) }}">
                        @csrf
                        <button class="btn btn-danger rechazar-button" type="button">Rechazar adelantamiento de turno</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rechazarTurno = document.querySelectorAll('.rechazar-button');

            rechazarTurno.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de rechazar el nuevo turno?',
                        text: "Al confirmar se rechazará el nuevo turno pero mantendrá el turno anterior.",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: '¡No, cancelar!',
                        confirmButtonColor: '#198754',
                        confirmButtonText: '¡Rechazar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('form-rechazar');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se rechazó el turno!'
                            )
                        }
                    })
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const confirmarTurno = document.querySelectorAll('.confirmar-button');

            confirmarTurno.forEach(button => {
                button.addEventListener('click', function () {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: true
                        })

                        swalWithBootstrapButtons.fire({
                        title: '¿Está seguro de confirmar el nuevo turno?',
                        text: "Al confirmar se cambiará la fecha del turno anterior a la fecha del turno nuevo.",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: '¡No, cancelar!',
                        confirmButtonColor: '#198754',
                        confirmButtonText: '¡Confirmar!',
                        cancelButtonColor: '#d33',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = document.getElementById('form-confirmar');
                            form.submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            '¡No se confirmó el turno!'
                            )
                        }
                    })
                });
            });
        });
    </script>
@stop
