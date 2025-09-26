<?php
class Form {
    var $fields = array();
    var $action;
    var $submit = "";
    var $jumField = 0;
    
    function __construct($action, $submit) {
        $this->action = $action;
        $this->submit = $submit;
    }
    
    function displayForm() {
        echo "<form action='".$this->action."' method='post' enctype='multipart/form-data'>";
        echo "<table width='100%' class='table'>";
        
        for($i = 0; $i < $this->jumField; $i++) {
            $field = $this->fields[$i];
            echo "<tr>";
            echo "<td align='right' width='30%'><label for='".$field['name']."' class='form-label'>".$field['label']."</label></td>";
            echo "<td width='70%'>";
            
            switch($field['type']) {
                case 'text':
                    echo "<input type='text' class='form-control' id='".$field['name']."' name='".$field['name']."' value='".($field['value'] ?? '')."'>";
                    break;
                    
                case 'password':
                    echo "<input type='password' class='form-control' id='".$field['name']."' name='".$field['name']."'>";
                    break;
                    
                case 'textarea':
                    echo "<textarea class='form-control' id='".$field['name']."' name='".$field['name']."' rows='4'>".($field['value'] ?? '')."</textarea>";
                    break;
                    
                case 'select':
                    echo "<select class='form-select' id='".$field['name']."' name='".$field['name']."'>";
                    foreach($field['options'] as $value => $label) {
                        $selected = (isset($field['value']) && $field['value'] == $value) ? 'selected' : '';
                        echo "<option value='".$value."' ".$selected.">".$label."</option>";
                    }
                    echo "</select>";
                    break;
                    
                case 'radio':
                    foreach($field['options'] as $value => $label) {
                        $checked = (isset($field['value']) && $field['value'] == $value) ? 'checked' : '';
                        echo "<div class='form-check form-check-inline'>";
                        echo "<input class='form-check-input' type='radio' id='".$field['name'].$value."' name='".$field['name']."' value='".$value."' ".$checked.">";
                        echo "<label class='form-check-label' for='".$field['name'].$value."'>".$label."</label>";
                        echo "</div>";
                    }
                    break;
                    
                case 'checkbox':
                    foreach($field['options'] as $value => $label) {
                        $checked = (isset($field['value']) && in_array($value, $field['value'])) ? 'checked' : '';
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='checkbox' id='".$field['name'].$value."' name='".$field['name']."[]' value='".$value."' ".$checked.">";
                        echo "<label class='form-check-label' for='".$field['name'].$value."'>".$label."</label>";
                        echo "</div>";
                    }
                    break;
                    
                case 'file':
                    echo "<input type='file' class='form-control' id='".$field['name']."' name='".$field['name']."'>";
                    if(isset($field['current_file']) && $field['current_file']) {
                        echo "<small class='text-muted'>File saat ini: ".$field['current_file']."</small>";
                    }
                    break;
            }
            
            echo "</td></tr>";
        }
        
        echo "<tr><td colspan='2' class='text-center'>";
        echo "<button type='submit' name='tombol' class='btn btn-primary' style='background-color: #F97A00; border-color: #F97A00;'>".$this->submit."</button>";
        echo "</td></tr>";
        echo "</table>";
        echo "</form>";
    }
    
    function addField($name, $label, $type = 'text', $options = array(), $value = null, $current_file = null) {
        $this->fields[$this->jumField] = array(
            'name' => $name,
            'label' => $label,
            'type' => $type,
            'options' => $options,
            'value' => $value,
            'current_file' => $current_file
        );
        $this->jumField++;
    }
    
    function getFieldValue($name) {
        foreach($this->fields as $field) {
            if($field['name'] == $name) {
                return $field['value'] ?? '';
            }
        }
        return '';
    }
}
?>