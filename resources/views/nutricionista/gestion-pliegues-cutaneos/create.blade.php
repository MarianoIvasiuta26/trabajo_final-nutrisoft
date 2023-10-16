@extends('adminlte::page')

@section('title', 'Agregar nuevo pliegue cutáneo')

@section('content_header')
@stop

@section('content')
    <form action="{{ route('gestion-pliegues-cutaneos.store') }}" method="POST">
        @csrf

        <div class="card card-dark mt-3">
            <div class="card-header">
                <h5>Nuevo pliegue cutáneo</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pliegue">Pliegue cutáneo(*)</label>
                        <input type="text" name="pliegue" class="form-control" tabindex="1">

                        @error('pliegue')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="unidad_de_medida">Unidad de medida(*)</label>
                        <select class="form-select" name="unidad_de_medida" id="unidad_de_medida">
                            <option value="">Seleccione una opción </option>
                            <option value="mm">Milímetros (mm)</option>
                            <option value="cm">Centímetros (cm)</option>
                            <option value="in">Pulgadas (in)</option>
                            <option value="µm">Micrómetros (µm)</option>
                            <option value="mils">Miles de pulgadas (mils)</option>
                            <option value="decimilimetros">Decenas de milímetros (decimilímetros)</option>
                        </select>

                        @error('unidad_de_medida')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" tabindex="3"></textarea>

                        @error('descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning mt-3" role="alert">
                    Los campos marcados con un (*) son obligatorios.
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="float-right">
                            <a type="button" href="{{ route('gestion-pliegues-cutaneos.index') }}" id="cancelar-button" class="btn btn-danger" tabindex="7">Cancelar</a>
                            <button type="submit" class="btn btn-success" id="guardar-button">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
         document.addEventListener('DOMContentLoaded', function () {
            const cancelarButtons = document.querySelectorAll('.cancelar-button');

            cancelarButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: '¿Estás seguro de cancelar el registro?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cancelar el registro'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            //Envia el form
                            const form = this.closest('form');
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>

@stop
