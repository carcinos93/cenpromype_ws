@extends('layout.master')
@section('scripts')
    <script>

    </script>
@endsection
@section('content')
<div class="position-relative w-100 h-100" style="cursor: pointer;background-color: #12539d;">
    <div class="position-absolute w-100 d-flex align-items-center" style="top:0%;left:0%;right:0;bottom: 0;z-index:99;">
        <div class="p-5 bg-white rounded-1 m-auto position-relative">
            <form id="formulario" role="form" [formGroup]="formulario" (ngSubmit)="enviarFormulario()">
                <div class="row pt-md-4 mb-md-3">
                    <div class="col-12 text-center">
                        <h4><b> ENTRAR AL ADMINISTRADOR </b></h4>
                    </div>
                </div>
                <div class="p-fluid">
                    <div class="p-field p-grid">
                        <label class="col-form-label p-col-3"> { "usuario"  } </label>
                        <div class="p-col">
                            <input [(ngModel)]="usuario" formControlName="usuario" class="form-control " type="text">
                            <div *ngIf="controlVerificacion('usuario')">
                                <div class="p-error" *ngIf="controlValido('usuario','required')">
                                    { "mensajes.requerido"  }
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-field p-grid">
                        <label class="col-form-label p-col-3"> {"password"  } </label>
                        <div class="p-col">
                            <input [(ngModel)]="password" formControlName="password" class="form-control " type="password">
                            <div *ngIf="controlVerificacion('password')">
                                <div class="p-error" *ngIf="controlValido('password','required')">
                                    { "mensajes.requerido"  }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-md-3">
                    <div class="col-md-9 m-auto">
                        <button type="submit" class="btn btn-primary w-100">
                            INICIAR SESIÓN
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="position-relative w-100 h-100 text-center" style="background-image: url('{{ asset('assets/images/elementos p. administrativo-05.png')  }}');background-size: cover;background-repeat: no-repeat;opacity: 0.35;">
    </div>
</div>
@endsection

