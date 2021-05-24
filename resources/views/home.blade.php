@include('/partials/header')

<h1 style="text-align:center">Muito Dinheiro</h1>

<div class="home">

    <div class="cadastro">
        Criar operação
        <form method="POST" action="/create">
            @csrf
            @if (session('msg'))
                <p class="msg">
                    {{ session('msg') }}
                </p>            
            @endif

            @if (session('error'))
                <p class="error">
                    {{ session('error') }}
                </p>            
            @endif
            <input class="wx" type="text" name="name" placeholder="nome do cliente" required>
            <br>
            @include('/partials/calculadora')
            <input type="submit" value="Enviar">
        </form>
    </div>
</div>