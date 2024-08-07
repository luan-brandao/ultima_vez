var map;
var directionsService;
var directionsRenderer;
var marcadorAtual; // Variável para armazenar o marcador da localização atual
var atualizarIntervalo; // Variável para armazenar o intervalo de atualização
var primeiraAtualizacao = true; // Variável para controlar a primeira atualização

function initMap() {
    // Cria o mapa
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: { lat: -22.915822982788086, lng: -42.819297790527344 }
    });

    // Inicializa os serviços de direção
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        map: map,
        suppressMarkers: true // Remover marcadores
    });

    // Mostrar localização atual e configurar intervalo de atualização
    mostrarLocalizacaoAtual();
    atualizarIntervalo = setInterval(function() {
        mostrarLocalizacaoAtual();
    }, 5000); // Atualiza a localização a cada 5 segundos

    // Adicionar marcadores para os motoristas
    adicionarMarcadoresMotoristas();
}

function mostrarLocalizacaoAtual() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var posicao = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            if (marcadorAtual) {
                // Atualiza a posição do marcador existente
                marcadorAtual.setPosition(posicao);
            } else {
                // Cria um novo marcador se não existir
                marcadorAtual = new google.maps.Marker({
                    position: posicao,
                    map: map,
                    title: 'Minha Localização'
                });
            }

            // Centraliza o mapa apenas na primeira execução
            if (primeiraAtualizacao) {
                map.setCenter(posicao);
                primeiraAtualizacao = false; // Marca que a primeira atualização já ocorreu
            }

        }, function() {
            console.error('Erro: Não foi possível acessar a geolocalização.');
        });
    } else {
        console.error('Erro: O navegador não suporta geolocalização.');
    }
}

function adicionarMarcadoresMotoristas() {
    // Iterar sobre os dados dos motoristas e adicionar marcadores no mapa
    motoristasData.forEach(function(motorista) {
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(motorista.latitude), lng: parseFloat(motorista.longitude) },
            map: map
        });

        // Adicione informações adicionais ao marcador, se necessário
        var infowindow = new google.maps.InfoWindow({
            content: '<h3>' + motorista.name + '</h3>'
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    });
}

function calcularRota(coordinates) {
    var pontos = coordinates;

    var waypoints = pontos.map(function(ponto) {
        return {
            location: ponto,
            stopover: true
        };
    });

    var request = {
        origin: pontos[0],
        destination: pontos[pontos.length - 1],
        waypoints: waypoints,
        travelMode: google.maps.TravelMode.DRIVING
    };

    directionsService.route(request, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(result);
        } else {
            console.error('Erro ao calcular rota:', status);
        }
    });
}

function toggleLateral() {
    var lateral = document.getElementById('lateral');
    var mapElement = document.getElementById('map');
    lateral.classList.toggle('abrir');
    mapElement.classList.toggle('lateral-aberta');
}

// Parar o intervalo de atualização quando necessário
function pararAtualizacaoLocalizacao() {
    clearInterval(atualizarIntervalo);
}
