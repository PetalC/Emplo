@props([
    'theme' => '',
    'id',
    'chart_data',
    'label_data',
    'title',
])
<div {{ $attributes->merge( [ 'class' => 'rounded-lg border-2 p-5' ] ) }} >
    <p class="text-center my-5">
        {{ $title }}
    </p>
    <div class="font-sans leading-normal tracking-normal">
        <canvas id="{{ $id }}" class=""></canvas>
    </div>
</div>

@push('scripts')
<script>
    var phpArray = <?php echo json_encode($label_data); ?>;

    var theme = "{{ $theme }}";
    var backgroundColors;
    if (theme == "green") {
        backgroundColors = [
            'rgb(187 247 208)',
            'rgb(74 222 128)',
            'rgb(22 101 52)',
        ]
    } 
    else if (theme == "blue"){
        backgroundColors = [
            'rgb(186 230 253)',
            'rgb(56 189 248)',
            'rgb(7 89 133)',
        ]
    }
    else{
        backgroundColors = [
            'rgb(229 229 229)',
            'rgb(163 163 163)',
            'rgb(38 38 38)',
        ]
    }

    var chartData = JSON.parse("{{ $chart_data }}");

    var labelString="{{ $label_data }}"
    var textarea = document.createElement('textarea');
    textarea.innerHTML = labelString;
    var labelData = JSON.parse(textarea.value);
    
    var ctx = document.getElementById('{{ $id }}').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labelData,
            datasets: [{
                data: chartData,
                backgroundColor:  backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: 'black',
                    fontSize: 14,
                    padding: 20
                }
            }
        }
    });
</script>
@endpush