@include('/partials/header')
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  overflow: auto;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

.invTd {
    border: none !important;
    background-color: transparent !important;
}

.tFooter {
    color: red !important;
}

input[type=submit] {
    margin-left: 5px
}

.searchContainer {
    display: flex;
}

</style>

<div class="searchContainer">
    <form action="/operations" style="margin-right: 10px">
        <input type="text" name="byName" placeholder="Pesquisar por nome" style="float:left">
        <input type="submit" value="Pesquisar" style="float:left">
    </form>

    <form action="/operations">
        <input type="date" name="byDateInit" style="margin-right:10px;float:left;padding: 10px 20px;" >
        <input type="date" name="byDateEnd" style="float:left;padding: 10px 20px;" >
        <input type="submit" value="Pesquisar entre datas" style="float:left">
    </form>
</div>



<table id="customers">
    <tr>
        <th>Data</th>
        <th>Cliente</th>
        <th>Valor Original</th>
        <th>Valor Final</th>
        <th>Taxa</th>
    </tr>

        @foreach ($operations as $operation)
        <tr>
            <td>{{ $operation->date }}</td>
            <td>{{ $operation->name }}</td>
            <td>{{ $operation->origin_currency }} {{ $operation->original_value }}</td>
            <td>{{ $operation->destiny_currency }} {{ $operation->converted_value }}</td>
            <td>{{ $operation->rate }}</td>
        </tr>
        @endforeach

    <tr class="invTd">
        <td class="invTd"></td>
        <td class="invTd"></td>
        <td class="invTd"></td>
        <td style="color:#ff574d">{{ $totalOperations }}</td>
        <td style="color:#ff574d">{{ $totalRate }}</td>
    </tr>
    <tr>
        <td class="invTd"></td>
        <td class="invTd"></td>
        <th class="invTd"></th>
        <th>Total de Operações</th>
        <th>Total de Taxas</th>
    </tr>
</table>
