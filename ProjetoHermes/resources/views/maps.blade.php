@extends('layouts.maps')
@section('title', 'Maps')
@section('content')
<header>
    <div class="menu-lateral">
        <div class="logo">
            <img src="/image/maps/logo.png" alt="Logo da Empresa">
        </div>
        <nav>
            <ul>
                <li><h3 href="#" class="opcao" ><strong>Rotas</strong></h3></li>
                <li><a href="#" class="rotas" onclick="alterarRota('rota2')">Inoa via itaocaia</a></li>
                <li><h3 href="#" class="opcao"><strong>Circular</strong></h3></li>
                <li><a href="#" class="rotas" onclick="alterarRota('rota2')">Recanto x Marica</a></li>
            </ul>
        </nav>
    </div>
    <div class="trigger-button"><img src="./image/maps/menu.png" alt="" width="17%" margin-left="5%"></div> </div>
    <h1><a href="/">Home</a></h1>
    <div class="user-profile">
        <!-- Botão de Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
        <!-- Nome do Usuário -->
        @if($userName)
        <div>
            <p>Bem-vindo,    {{ $userName }}</p>
        </div>
        @endif
        <!-- Círculo com a Imagem de Perfil do Usuário -->
        <div class="profile-circle">
            <!-- Substitua 'user.jpg' pelo caminho da imagem do perfil do usuário -->
            <img src="/image/maps/OIP.jpg" alt="Perfil do Usuário">
        </div>
    </div>
</header>

<script src="/js/maps/script.js"></script>

<style>
    .user-profile {
        position: fixed;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
    }

    .user-profile button {
        margin-right: 10px;
    }

    .profile-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
    }

    .profile-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection
