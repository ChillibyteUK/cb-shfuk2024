<?php
$class = $block['className'] ?? 'pt-5';
?>
<section class="calculator <?=$class?>">
    <div class="container-xl">
        <h2><?=get_field('calculator_title','options')?></h2>
        <div class="calculator__grid">
            <div class="calculator__slider">
                <label class="calculator__label" for="slider">Property Value</label>
                <input class="calculator__range" type="range" id="slider" min="<?=get_field('min_value','options')?>" max="<?=get_field('max_value','options')?>" step="10000" value="<?=get_field('default_value','options')?>">
            </div>
            <div id="currentValue" class="calculator__current current-value"></div>
            <div class="calculator__message"><div>All your legal <strong>fees included</strong> as part of our service.</div></div>
            <div class="calculator__arrow"></div>
            <div class="calculator__output_inner">
                <div class="calculator__output_title"><?=get_field('output_title','options')?></div>
                <div class="calculator__output_value" id="outputValue"></div>
            </div>
        </div>
    </div>
</section>

<script>
    const slider = document.getElementById('slider');
    const output = document.getElementById('outputValue');
    const currentValue = document.getElementById('currentValue');

    function updateOutput() {
        const value = parseInt(slider.value, 10);
        const percentage = parseFloat('<?=get_field("percentage", "options")?>') / 100;
        const calculatedValue = Math.floor(value * percentage);

        currentValue.textContent = new Intl.NumberFormat('en-GB', { style: 'currency', currency: 'GBP', maximumFractionDigits: 0 }).format(value);
        output.textContent = new Intl.NumberFormat('en-GB', { style: 'currency', currency: 'GBP', maximumFractionDigits: 0 }).format(calculatedValue);
    }

    slider.addEventListener('input', updateOutput);

    updateOutput();
</script>
