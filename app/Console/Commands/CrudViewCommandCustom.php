<?php

namespace App\Console\Commands;

use Appzcoder\CrudGenerator\Commands\CrudViewCommand;
use File;

class CrudViewCommandCustom extends CrudViewCommand
{

    public function templateIndexVars($newIndexFile)
    {
        $dataColumns = $columnsDefs = $columnsToHide = $formHeadingHtml = [];
        foreach ($this->formFields as $field) {
            $formHeadingHtml[] = '<th>'.ucwords(str_replace('_', ' ', $field['name'])).'</th>';
            switch ($field['name']) {
                case 'name':
                    $dataColumns[] = "{
                        'data': 'name',
                        'render': function (data, type, full, meta) {
                            var view_btn = '<a href=\"/%%routeGroup%%%%crudName%%/' + full._id + '\">' + data + '</a>';
                            var edit_btn = '<a href=\"/%%routeGroup%%%%crudName%%/' + full._id + '/edit\" class=\"btn-xs btn-link\"><i class=\"icon-pencil4\"></i></a>';
                            var delete_btn = '{!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => \"/%%routeGroup%%%%crudName%%/full_id\" ,
                                        'style' => 'display:inline'
                                    ]) !!}{!! Form::button('<i class=\"icon-bin\" alt=\"edit\"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-link']) !!}{!! Form::close() !!}';
                            return view_btn + '&nbsp;' + edit_btn + '&nbsp;' + delete_btn.replace('full_id', full._id);
                        }
                    }";
                    $columnsDefs[] = "'{$field['name']}'";
                    break;
                case 'id':
                    $dataColumns[] = "{'data': '{$field['name']}'}";
                    // we don't want id in columnsDefs
                    break;
                default:
                    $dataColumns[] = "{'data': '{$field['name']}'}";
                    $columnsDefs[] = "'{$field['name']}'";
                    break;
            }
        }

        for ($cont = -1; $cont > (-1 * count($this->formFields)) + $this->defaultColumnsToShow; $cont --) {
            $columnsToHide[] = $cont;
        }

        File::put($newIndexFile, str_replace('%%dataColumns%%', implode(',', $dataColumns), File::get($newIndexFile)));
        File::put($newIndexFile, str_replace('%%formHeadingHtml%%', implode('', $formHeadingHtml), File::get($newIndexFile)));
        File::put($newIndexFile, str_replace('%%columnsDefs%%', implode(',', $columnsDefs), File::get($newIndexFile)));
        File::put($newIndexFile, str_replace('%%columnsToHide%%', implode(',', $columnsToHide), File::get($newIndexFile)));
        parent::templateIndexVars($newIndexFile);
    }

    public function templateShowVars($newShowFile)
    {
        $formFieldsHtml = '';
        foreach ($this->formFields as $item) {
            $label = "'".ucwords(strtolower(str_replace('_', ' ', $item['name'])))."'";
            if ($this->option('localize') == 'yes') {
                $label = 'trans(\'' . $this->crudName . '.' . $item['name'] . '\')';
            }
            $str = "
            <div class=\"form-group\">
                {!! Form::label('{$item['name']}', {$label}, ['class' => 'col-sm-3 control-label']) !!}
                <div class=\"col-sm-6\">
                    {!! Form::input('" . $this->typeLookup[$item['type']] . "', '" . $item['name'] . "', \$%%crudNameSingular%%->{$item['name']}, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>";

            $formFieldsHtml .= $str;
        }

        File::put($newShowFile, str_replace('%%crudNameSingularCap%%', ucwords($this->crudNameSingular), File::get($newShowFile)));
        File::put($newShowFile, str_replace('%%formFieldsHtml%%', $formFieldsHtml, File::get($newShowFile)));
        parent::templateShowVars($newShowFile);
    }

    public function templateCreateVars($newCreateFile)
    {
        File::put($newCreateFile, str_replace('%%crudNameSingularCap%%', ucwords($this->crudNameSingular), File::get($newCreateFile)));

        parent::templateCreateVars($newCreateFile);
    }

    public function templateEditVars($newEditFile)
    {
        File::put($newEditFile, str_replace('%%crudNameSingularCap%%', ucwords($this->crudNameSingular), File::get($newEditFile)));

        parent::templateEditVars($newEditFile);
    }
}
