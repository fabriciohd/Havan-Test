<select name="moedas1" id="moedas1" onchange="converter(2);">        
</select>
<input type="number" name="valor1" id="valor1" onkeyup="converter(1)" placeholder="valor de origem" step="0.01" required>    
<br>    
<select name="moedas2" id="moedas2" onchange="converter(1)">        
</select>
<input type="number" name="valor2" id="valor2" onkeyup="converter(2)" placeholder="valor convertido" step="0.01" required>
<br>
<input class="wx" type="text" name="taxa" id="taxa" placeholder="taxa">


<script>
var moedas = [
    'BRL',
    'USD',
    'EUR',
]

select = document.getElementById('moedas1');
select2 = document.getElementById('moedas2');
moedas.forEach(element => {
    var opt = document.createElement('option');
    opt.value = element;
    opt.innerHTML = element;
    select.appendChild(opt);

    var opt = document.createElement('option');
    opt.value = element;
    opt.innerHTML = element;
    select2.appendChild(opt);
});

function converter(input) {
    var selectFrom = document.getElementById("moedas"+input);
    var from = selectFrom.options[selectFrom.selectedIndex].value;

    if(input == 1) {
        var selectTo = document.getElementById("moedas2");
        var to = selectTo.options[selectTo.selectedIndex].value;
        var inputFrom = document.getElementById('valor1').value;
        var inputTo = document.getElementById('valor2');
    } else if (input == 2) {
        var selectTo = document.getElementById("moedas1");
        var to = selectTo.options[selectTo.selectedIndex].value;
        var inputTo = document.getElementById('valor1');
        var inputFrom = document.getElementById('valor2').value;
    }

    fetch('https://economia.awesomeapi.com.br/last/'+from+'-'+to)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            inputTo.value = (data[from+to]['ask'] * inputFrom).toFixed(2);            
        })
        .catch(function(error) {
            inputTo.value = inputFrom;
    });

    setTimeout(() => {
        calcTaxa();        
    }, 200);
    
}

function calcTaxa() {
    var taxa = document.getElementById("taxa");
    
    taxa.value = document.getElementById('moedas1').value + ' ' +( document.getElementById('valor1').value / 10).toFixed(2);
}
</script>