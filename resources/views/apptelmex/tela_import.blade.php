<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Crear</h3>
        <!--
        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 10px">
              <a href="{{$action}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;Lista</a>
            </div>
        </div>
      -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <form method="post" action="{{$action}}" id="import" pjax-container>

            <div class="box-body">

                <div class="form-horizontal">

                <div class="form-group">

                    <label for="inputTableName" class="col-sm-2 control-label">Proceso</label>

                    <div class="col-sm-4">
                        <input type="text" name="proceso" class="form-control" id="inputTableName" placeholder="Proceso de carga masiva" value="{{ old('proceso') }}">
                    </div>

                    <span class="help-block hide" id="table-name-help">
                        <i class="fa fa-info"></i>&nbsp; Se requiere un valor !
                    </span>

                </div>
                <div class="form-group">
                    <label for="inputDescripcion" class="col-sm-2 control-label">Descripción</label>

                    <div class="col-sm-4">
                        <input type="text" name="descripcion" class="form-control" id="inputDescripcion" placeholder="Descripción" value="{{ old('descripcion') }}">
                    </div>
                    <span class="help-block hide" id="table-desc-help">
                        <i class="fa fa-info"></i>&nbsp; Se requiere un valor !
                    </span>
                </div>

                <div class="form-group">
                    <label for="inputTabla" class="col-sm-2 control-label">Tabla Maestra</label>

                    <div class="col-sm-4">
  <input type="text" name="modelo" class="form-control" id="inputTabla" placeholder="Tabla principal" value="{{ old('modelo') }}" >
                    </div>
                    <span class="help-block hide" id="table-tabla-help">
                        <i class="fa fa-info"></i>&nbsp; Se requiere un valor !
                    </span>
                </div>


                </div>

                <hr />

                <h4>Campos a Importar</h4>

                <table class="table table-hover" id="table-fields">
                    <tbody>
                    <tr>
                        <th style="width: 200px">Nombre del campo</th>
                        <th>Tipo</th>
                        <th>No Nulos</th>
                        <th>Validación</th>
                        <th colspan="2">Tabla</th>
                        <th>Action</th>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="tela_import_fields[0][field]" class="form-control" placeholder="field name" />
                        </td>
                        <td>
                            <select style="width: 200px" name="tela_import_fields[0][tipo]">
                                @foreach($dbTypes as $type)
                                    <option value="{{ $type }}">{{$type}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="checkbox" name="tela_import_fields[0][nulos]" value='on' checked /></td>
                        <td>
                            <select style="width: 150px" name="tela_import_fields[0][rule]">
                                {{--<option value="primary">Primary</option>--}}
                                <option value="" selected>NULL</option>
                                <option value="unique">Unique</option>

                            </select>
                        </td>
                        <td><a class="btn btn-sm" onclick="$('#exito').val($('#inputTabla').val());">
                          <i class="fa fa-copy"></i> </a></td>
                        <td>
                          <input type="text" class="form-control" placeholder="default value" name="tela_import_fields[0][model]" id="exito" value=""></td>
                        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> eliminar</a></td>
                    </tr>

                    </tbody>
                </table>

                <hr style="margin-top: 0;"/>

                <div class='form-inline margin' style="width: 100%">
                    <div class='form-group'>
                        <button type="button" class="btn btn-sm btn-success" id="add-table-field">
                          <i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo Campo</button>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Crear</button>
            </div>

            {{ csrf_field() }}

            <!-- /.box-footer -->
        </form>

    </div>

</div>

<template id="table-field-tpl">
    <tr>
        <td>
            <input type="text" name="tela_import_fields[__index__][field]" class="form-control" placeholder="field name" />
        </td>
        <td>
            <select style="width: 200px" name="tela_import_fields[__index__][tipo]">
                @foreach($dbTypes as $type)
                    <option value="{{ $type }}">{{$type}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="checkbox" name="tela_import_fields[__index__][nulos]" value='on' checked/></td>
        <td>
            <select style="width: 150px" name="tela_import_fields[__index__][rule]">
                <option value="" selected>NULL</option>
                <option value="unique">Unique</option>
            </select>
        </td>
        <td><a class="btn btn-sm" onclick="$('#exito__index__').val($('#inputTabla').val());">
          <i class="fa fa-copy"></i> </a></td>
        <td>

          <input type="text" class="form-control" placeholder="default value" name="tela_import_fields[__index__][model]" id="exito__index__"></td>
        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a></td>
    </tr>
</template>


<script>

$(function () {

    $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    $('select').select2();



    $('#add-table-field').click(function (event) {
        $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, $('#table-fields tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    });

    $('#table-fields').on('click', '.table-field-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#add-model-relation').click(function (event) {
        $('#model-relations tbody').append($('#model-relation-tpl').html().replace(/__index__/g, $('#model-relations tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});

        relation_count++;
    });

    $('#model-relations').on('click', '.model-relation-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#import').on('submit', function (event) {

        //event.preventDefault();

        if ($('#inputTableName').val() == '') {
            $('#inputTableName').closest('.form-group').addClass('has-error');
            $('#table-name-help').removeClass('hide');

            return false;
        }
        if ($('#inputDescripcion').val() == '') {
            $('#inputDescripcion').closest('.form-group').addClass('has-error');
            $('#table-desc-help').removeClass('hide');

            return false;
        }
        if ($('#inputTabla').val() == '') {
            $('#inputTabla').closest('.form-group').addClass('has-error');
            $('#table-tabla-help').removeClass('hide');

            return false;
        }

        return true;
    });
});

</script>
