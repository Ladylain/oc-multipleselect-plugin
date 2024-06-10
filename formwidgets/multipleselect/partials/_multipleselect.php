<?php
    $fieldOptions = $fieldOptions;
    $checkedValues = (array) $field->value;
    $isScrollable = count($fieldOptions) > 10;
    $inlineOptions = $field->inlineOptions && !$isScrollable;
    $isQuickselect = $field->getConfig('quickselect', $isScrollable);
?>
<!-- Multiple Select -->
<?php if ($this->previewMode): ?>
    <?php if ($field->value): ?>
        <?= $field->value ?>
    <?php else: ?>
        <!-- No options specified -->
        <?php if ($field->placeholder): ?>
            <p><?= e(__($field->placeholder)) ?></p>
        <?php endif ?>
    <?php endif ?>
<?php else: ?>
    <div class="field-multipleselect control-disabled">
            <div class="row">
                <div class="col-lg-5">
                    <select name="from[]" id="<?= $field->getId() ?>" class="form-control" size="8" multiple="multiple">
                        <?php if (count($fieldOptions)): ?>
                            <?php $index = 0; foreach ($fieldOptions as $value => $option): ?>
                                <?php
                                    $index++;
                                    $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                                    if (in_array($value, $checkedValues)) continue;
                                    if (!is_array($option)) $option = [$option];
                                ?>
                                <option value="<?= e($value) ?>"><?= $field->getDisplayValue($option[0]) ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="col-lg-2 d-flex flex-column align-items-center justify-content-center">
                    <button type="button" id="<?= $field->getId() ?>_rightAll" class="btn btn-block" style="color:var(--bs-body-color);"><i class=" icon-forward"></i></button>
                    <button type="button" id="<?= $field->getId() ?>_rightSelected" class="btn btn-block" style="color:var(--bs-body-color);"><i class="icon-chevron-right"></i></button>
                    <button type="button" id="<?= $field->getId() ?>_leftSelected" class="btn btn-block" style="color:var(--bs-body-color);"><i class="icon-chevron-left"></i></button>
                    <button type="button" id="<?= $field->getId() ?>_leftAll" class="btn btn-block" style="color:var(--bs-body-color);"><i class="icon-backward"></i></button>
                </div>
                <div class="col-lg-5">
                    <select name="to[]" id="<?= $field->getId() ?>_to" class="form-control" size="8" multiple="multiple">
                        <?php if (count($fieldOptions)): ?>
                            <?php $index = 0; foreach ($fieldOptions as $value => $option): ?>
                                <?php
                                    $index++;
                                    $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                                    if (!in_array($value, $checkedValues)) continue;
                                    if (!is_array($option)) $option = [$option];
                                ?>
                                <option value="<?= e($value) ?>"><?= $field->getDisplayValue($option[0]) ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <!-- on affiche un champs caché qui permet de récuperer les valeurs du select multiple -->
                <input type="hidden" name="<?= $field->getName() ?>" value="<?= join(',', $checkedValues) ?>">
            </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function($) {
            $('#<?= $field->getId() ?>').multiselect({
                submitAllLeft:false,
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="<?= Lang::get('ladylain.multipleselect::lang.multipleselect.placeholder')?>" />',
                    right: '<input type="text" name="q" class="form-control" placeholder="<?= Lang::get('ladylain.multipleselect::lang.multipleselect.placeholder')?>" />',
                },
                fireSearch: function(value) {
                    return value.length > 3;
                },
                afterMoveToRight: function(event, data) {
                    var selectedValues = [];
                    $('#<?= $field->getId() ?>_to option').each(function() {
                        selectedValues.push($(this).val());
                    });
                    $('input[name="<?= $field->getName() ?>"]').val(selectedValues);
                },
                afterMoveToLeft: function(event, data) {
                    var selectedValues = [];
                    $('#<?= $field->getId() ?>_to option').each(function() {
                        selectedValues.push($(this).val());
                    });
                    $('input[name="<?= $field->getName() ?>"]').val(selectedValues);
                }
            });
        });
        </script>
<?php endif; ?>
