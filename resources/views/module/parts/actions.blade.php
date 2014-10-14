@if ($mode == "ADD")
@include('module.parts.create-mode-actions')
@elseif ($mode == "EDIT")
@include('module.parts.edit-mode-actions')
@endif