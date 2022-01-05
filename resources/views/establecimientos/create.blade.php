@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" 
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" 
    crossorigin="" />

    <!-- Esri Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"/>

    <!-- Dropzone para almacenar imagenes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" 
    integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('content')
<div class="container">
        <!-- mensaje de guardado -->
        @if(session('estado'))
        <div class="alert alert-primary" role="alert">
            {{ session('estado') }}
        </div>
        @endif
    <h1 class="text-center mt-4">Registrar Establecimiento</h1>

    <div class="mt-5 row justify-content-center">
        <form class="col-md-9 col-xs-12 card card-body"
            action="{{route('establecimiento.store')}}" 
            method="POST"
            enctype="multipart/form-data"
        >
        @csrf
            <fieldset class="border p-4">
                <legend class="text-primary">Nombre y Categoría</legend>

                <div class="form-group">
                    <label for="nombre">Nombre del establecimiento</label>
                    <input 
                    type="text" 
                    name="nombre" 
                    class="form-control @error('nombre') is-invalid @enderror" 
                    placeholder="Agregar establecimiento"
                    id="nombre"
                    value="{{ old('nombre')}}">
                    @error('nombre')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select id="categoria_id" class="form-control @error('categoria') is-invalid @enderror" 
                        name="categoria_id">
                            <option value="" selected disabled>[Seleccione]</option>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}"
                                {{old('categoria_id') == $categoria->id ? 'selected' : ''}}>
                                    {{$categoria->nombre}}
                                </option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    <label for="imagen_principal">Imagen Principal</label>
                    <input 
                    type="file" 
                    name="imagen_principal" 
                    class="form-control @error('imagen_principal') is-invalid @enderror" 
                    id="imagen_principal"
                    value="{{ old('imagen_principal')}}">
                    @error('imagen_principal')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
            </fieldset>

            <fieldset class="border p-4">
                <legend class="text-primary">Ubicación</legend>

                <div class="form-group">
                    <label for="formbuscador">Dirección del Establecimiento</label>
                    <input 
                    type="text" 
                    id="formbuscador" 
                    class="form-control"
                    placeholder="Ubicación del establecimiento">
                    <p class="text-secondary mt-4 mb-3 text-center">Dirección estimada</p>
                </div>

                <div class="card border-secondary mb-3" style="max-width: 70rem; height: 35rem;">
                    <div class="card-header">Ubicación</div>
                    <div class="card-body text-secondary" id="mapa">
                    <h5 class="card-title">Secondary card title</h5>
                    
                    </div>
                </div>

                <p class="informacion">Confirma que los campos son correctos</p>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input 
                        id="direccion" 
                        name="direccion"
                        class="form-control @error('direccion') is-invalid @enderror" 
                        type="text" 
                        placeholder="dirección"
                        value="{{old('direccion')}}">
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="colonia">Colonia</label>
                    <input 
                        id="colonia" 
                        name="colonia"
                        class="form-control @error('colonia') is-invalid @enderror" 
                        type="text" 
                        placeholder="colonia"
                        value="{{old('colonia')}}">
                        @error('colonia')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                </div>

                <input type="hidden" value="{{old('lat')}}" id="lat" name="lat">
                <input type="hidden" value="{{old('lng')}}" id="lng" name="lng">
            </fieldset>

            <fieldset class="border p-4 mt-5">
                <legend  class="text-primary">Información Establecimiento: </legend>
                    <div class="form-group">
                        <label for="nombre">Teléfono</label>
                        <input 
                            type="tel" 
                            class="form-control @error('telefono')  is-invalid  @enderror" 
                            id="telefono" 
                            placeholder="Teléfono Establecimiento"
                            name="telefono"
                            value="{{ old('telefono') }}"
                        >

                            @error('telefono')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                    </div>

                    

                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <textarea
                            class="form-control  @error('descripcion')  is-invalid  @enderror" 
                            name="descripcion"
                        >{{ old('descripcion') }}</textarea>

                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Apertura:</label>
                        <input 
                            type="time" 
                            class="form-control @error('apertura')  is-invalid  @enderror" 
                            id="apertura" 
                            name="apertura"
                            value="{{ old('apertura') }}"
                        >
                        @error('apertura')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Cierre:</label>
                        <input 
                            type="time" 
                            class="form-control @error('cierre')  is-invalid  @enderror" 
                            id="cierre" 
                            name="cierre"
                            value="{{ old('cierre') }}"
                        >
                        @error('cierre')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
            </fieldset>
            
            <fieldset class="border p-4 mt-5">
                <legend  class="text-primary">Imagenes</legend>
                    <div class="form-group">
                        <div class="dropzone form-control" id="dropzone">

                        </div>
                    </div>
            </fieldset>

            <input type="hidden" name="uuid" id="uuid" value="{{ Str::uuid()->toString() }}">
            <input type="submit" class="btn btn-primary mt-3 d-block" value="Registrar Establecimiento" >
        </form>

    </div>
    @section('scripts')
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" 
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" 
        crossorigin="">
        </script>
        
        <script src="https://unpkg.com/esri-leaflet" defer></script>
        <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" 
        integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" 
        referrerpolicy="no-referrer" defer>
        </script>

    @endsection
</div>
@endsection