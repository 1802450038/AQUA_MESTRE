<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aquamanager | Automação para Aquaponia</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js para gráficos de custo -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- Animações Fundo --- */
        .fish-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .fish {
            position: absolute;
            font-size: 2rem;
            opacity: 0.6;
            animation: swim linear infinite;
        }

        @keyframes swim {
            from {
                transform: translateX(110vw) scaleX(1);
            }

            to {
                transform: translateX(-10vw) scaleX(1);
            }
        }

        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: rise linear infinite;
            z-index: 9999;
        }

        @keyframes rise {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) scale(1.5);
                opacity: 0;
            }
        }

        /* --- Diagrama Interativo --- */
        .water-flow {
            background: linear-gradient(180deg, #3b82f6 50%, transparent 50%);
            background-size: 200% 200%;
            animation: flow 2s linear infinite;
        }

        @keyframes flow {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 0% 100%;
            }
        }

        .flow-up {
            background: linear-gradient(0deg, #3b82f6 50%, transparent 50%);
            background-size: 200% 200%;
            animation: flow-reverse 2s linear infinite;
        }

        @keyframes flow-reverse {
            0% {
                background-position: 0% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .system-component {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .system-component:hover {
            /* transform: scale(1.05); */
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
            z-index: 10;
            border-color: #fbbf24;
        }

        .active-component {
            border-color: #fbbf24 !important;
            box-shadow: 0 0 25px rgba(251, 191, 36, 0.5);
            /* transform: scale(1.05); */
        }

        /* --- Cards de Sensores Interativos --- */
        .sensor-card {
            transition: all 0.3s ease;
        }

        .sensor-card.active {
            background-color: white;
            border-left: 4px solid #0891b2;
            /* Cyan-600 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Navegação -->
    <nav class="fixed w-full z-50 glass-panel bg-slate-900/95 text-white border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-water text-cyan-400 text-2xl"></i>
                    <span class="font-bold text-xl tracking-wider">AQUAMANAGER</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#home"
                            class="hover:bg-slate-700 px-3 py-2 rounded-md text-sm font-medium transition">Início</a>
                        <a href="#sobre"
                            class="hover:bg-slate-700 px-3 py-2 rounded-md text-sm font-medium transition">Sobre</a>
                        <a href="#sistema"
                            class="hover:bg-slate-700 px-3 py-2 rounded-md text-sm font-medium transition">Sistema</a>
                        <a href="#sensores"
                            class="hover:bg-slate-700 px-3 py-2 rounded-md text-sm font-medium transition">Sensores</a>
                        <a href="#custos"
                            class="hover:bg-slate-700 px-3 py-2 rounded-md text-sm font-medium transition">Viabilidade</a>
                        <a href="#concorrentes"
                            class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded-md text-sm font-medium transition">Diferenciais</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home"
        class="relative h-screen flex items-center justify-center bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900 overflow-hidden text-white">
        <div class="fish-container" id="fishContainer"></div>
        <div class="absolute inset-0 z-0 pointer-events-none" id="bubblesContainer"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <div
                class="mb-4 inline-block bg-cyan-900/50 backdrop-blur px-4 py-1 rounded-full border border-cyan-500/30 text-cyan-300 font-semibold text-sm">
                Projeto Aquapampa | Unipampa
            </div>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                O Futuro da <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-400">Aquaponia
                    IoT</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Monitoramento inteligente e acessível, desenvolvido no Mestrado em Engenharia.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#sistema"
                    class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300">
                    Ver Funcionamento
                </a>
            </div>
        </div>
    </section>

    <!-- SEÇÃO SOBRE -->
    <section id="sobre" class="py-20 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">O Projeto <span
                            class="text-cyan-600">Aquapampa</span></h2>
                    <p class="text-gray-600 mb-4 leading-relaxed text-justify">
                        Desenvolvido no âmbito do <strong>Mestrado em Engenharia da Unipampa (Alegrete)</strong>, o
                        Aquamanager nasceu para resolver um problema crítico: a dificuldade de monitorar simultaneamente
                        a qualidade da água para peixes e plantas em sistemas de aquaponia.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed text-justify">
                        A aquaponia une a <strong>Aquicultura</strong> (criação de peixes) com a
                        <strong>Hidroponia</strong> (cultivo de plantas sem solo). É um sistema fechado onde os dejetos
                        dos peixes nutrem as plantas, que por sua vez filtram a água devolvendo-a limpa aos peixes.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-cube text-cyan-600 text-2xl mb-2"></i>
                            <h4 class="font-bold">Modular</h4>
                            <p class="text-sm text-gray-500">Expansível com novos sensores.</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-wifi text-emerald-600 text-2xl mb-2"></i>
                            <h4 class="font-bold">Remoto 24/7</h4>
                            <p class="text-sm text-gray-500">Interface Web e Logs históricos.</p>
                        </div>
                    </div>
                </div>
                <div
                    class="relative h-80 bg-slate-200 rounded-2xl overflow-hidden shadow-xl flex items-center justify-center">
                    <!-- Placeholder Ilustrativo -->
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-900 to-slate-900 opacity-90"></div>
                    <div class="relative z-10 text-center text-white p-8">
                        <i class="fa-solid fa-graduation-cap text-6xl mb-4 text-white/80"></i>
                        <h3 class="text-2xl font-bold">PPEng - Unipampa</h3>
                        <p class="mt-2 text-white/70">Pesquisa Aplicada em IoT e Automação</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Interativa do Sistema -->
    <section id="sistema" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Diagrama do Sistema</h2>
                <p class="mt-4 text-gray-600">Interaja com os componentes para entender o fluxo.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Info Panel -->
                <div class="lg:col-span-1 order-2 lg:order-1">
                    <div id="info-panel"
                        class="bg-white p-8 rounded-2xl shadow-xl border border-slate-200 sticky top-24">
                        <div class="flex items-center gap-3 mb-4">
                            <div id="info-icon"
                                class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 text-xl">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <h3 id="info-title" class="text-xl font-bold text-slate-800">Visão Geral</h3>
                        </div>
                        <p id="info-desc" class="text-gray-600 leading-relaxed mb-6">
                            Clique nos elementos do diagrama ao lado (Tanque, Plantas, Sensores, ESP32) para ver
                            detalhes técnicos.
                        </p>
                        <div id="live-data" class="hidden border-t pt-4 border-gray-200">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">Status (Simulado)
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600"><i
                                            class="fa-solid fa-temperature-half mr-2"></i>Temp</span>
                                    <span class="font-mono font-bold text-slate-800">26.5°C</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600"><i class="fa-solid fa-flask mr-2"></i>pH</span>
                                    <span class="font-mono font-bold text-green-600">7.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagrama Animado -->
                <div
                    class="lg:col-span-2 order-1 lg:order-2 relative h-[500px] bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border-4 border-slate-800 select-none">

                    <!-- Cama de Cultivo -->
                    <div onclick="selectComponent('growbed')"
                        class="system-component absolute top-8 left-1/2 transform -translate-x-1/2 w-3/4 h-28 bg-slate-800 rounded-lg border-2 border-emerald-500/50 flex flex-col items-center justify-end z-20">
                        <div class="absolute -top-6 flex gap-4 text-emerald-400 text-3xl">
                            <i class="fa-solid fa-seedling animate-bounce" style="animation-delay: 0s"></i>
                            <i class="fa-solid fa-leaf animate-bounce" style="animation-delay: 0.2s"></i>
                        </div>
                        <span class="text-white font-semibold mb-2 text-sm"><i
                                class="fa-solid fa-carrot text-emerald-400 mr-2"></i>Hidroponia</span>
                    </div>

                    <!-- Tubulação -->
                    <div class="absolute top-24 right-[15%] w-3 h-48 bg-slate-700">
                        <div class="w-full h-full water-flow opacity-70"></div>
                    </div>
                    <div class="absolute top-24 left-[15%] w-3 h-48 bg-slate-700">
                        <div class="w-full h-full flow-up opacity-70"></div>
                    </div>

                    <!-- Bomba -->
                    <div onclick="selectComponent('pump')"
                        class="system-component absolute bottom-24 left-[13%] w-10 h-10 bg-gray-600 rounded-full border border-gray-400 flex items-center justify-center z-20">
                        <i class="fa-solid fa-fan text-white fa-spin text-xs" style="animation-duration: 3s;"></i>
                    </div>

                    <!-- Tanque -->
                    <div onclick="selectComponent('tank')"
                        class="system-component absolute bottom-6 left-1/2 transform -translate-x-1/2 w-3/4 h-40 bg-blue-900/40 rounded-xl border-2 border-cyan-500/50 backdrop-blur-sm flex items-end justify-center pb-2">
                        <span class="text-cyan-100 font-semibold text-sm"><i
                                class="fa-solid fa-fish text-cyan-400 mr-2"></i>Aquicultura</span>
                        <div class="absolute top-10 left-10 text-xl animate-pulse">🐟</div>
                        <div class="absolute top-16 right-12 text-xl animate-pulse" style="animation-delay: 1s">🐠
                        </div>
                    </div>

                    <!-- ESP-32 -->
                    <div onclick="selectComponent('controller')"
                        class="system-component absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-24 bg-gray-900 rounded border-2 border-yellow-500/70 shadow-[0_0_20px_rgba(234,179,8,0.3)] flex flex-col items-center justify-center z-30">
                        <span class="text-yellow-500 font-bold font-mono text-sm">ESP-32</span>
                        <div class="flex gap-1 mt-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEÇÃO SENSORES INTERATIVA -->
    <section id="sensores" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-slate-800 mb-12">Raio-X dos Sensores</h2>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Lista de Sensores -->
                <div class="md:w-1/3 space-y-2">
                    <button onclick="showSensor('ph')"
                        class="sensor-card active w-full text-left p-4 rounded-lg hover:bg-slate-50 flex items-center gap-4 transition"
                        id="btn-ph">
                        <div
                            class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Sensor de pH</h4>
                            <p class="text-xs text-gray-500">Qualidade da Água</p>
                        </div>
                    </button>

                    <button onclick="showSensor('temp')"
                        class="sensor-card w-full text-left p-4 rounded-lg hover:bg-slate-50 flex items-center gap-4 transition"
                        id="btn-temp">
                        <div
                            class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                            <i class="fa-solid fa-temperature-full"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Temperatura</h4>
                            <p class="text-xs text-gray-500">Controle Metabólico</p>
                        </div>
                    </button>

                    <button onclick="showSensor('level')"
                        class="sensor-card w-full text-left p-4 rounded-lg hover:bg-slate-50 flex items-center gap-4 transition"
                        id="btn-level">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-ruler-vertical"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Nível Ultrassônico</h4>
                            <p class="text-xs text-gray-500">Prevenção de Vazamentos</p>
                        </div>
                    </button>

                    <button onclick="showSensor('relay')"
                        class="sensor-card w-full text-left p-4 rounded-lg hover:bg-slate-50 flex items-center gap-4 transition"
                        id="btn-relay">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-power-off"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Módulo Relé</h4>
                            <p class="text-xs text-gray-500">Automação da Bomba</p>
                        </div>
                    </button>
                </div>

                <!-- Detalhes do Sensor (Dinâmico) -->
                <div class="md:w-2/3 bg-slate-50 rounded-2xl p-8 border border-slate-200 flex flex-col justify-center min-h-[300px]"
                    id="sensor-detail-container">
                    <div class="flex items-center gap-4 mb-6">
                        <i class="fa-solid fa-flask text-4xl text-purple-600" id="detail-icon"></i>
                        <h3 class="text-2xl font-bold text-slate-800" id="detail-title">Sensor de pH (pH4502C)</h3>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed" id="detail-desc">
                        O pH é crucial para a disponibilidade de nutrientes. Mede a acidez ou alcalinidade (0-14).
                        No Aquamanager, mantemos o pH próximo de 7, ideal para a nitrificação das bactérias e absorção
                        pelas plantas.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase">Faixa Ideal</span>
                            <div class="text-lg font-bold text-slate-800" id="detail-range">6.0 - 7.5 pH</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase">Função Crítica</span>
                            <div class="text-sm font-medium text-slate-800" id="detail-func">Saúde das Bactérias
                                Nitrificantes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEÇÃO CUSTOS/VIABILIDADE (Revisada) -->
    <section id="custos" class="py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Viabilidade Econômica</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Texto Dissertativo -->
                <div class="space-y-6">
                    <div class="bg-slate-800 p-8 rounded-xl border border-slate-700">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-cyan-400">
                            <i class="fa-solid fa-microchip"></i> Filosofia de Hardware Livre
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            O Aquamanager foi projetado priorizando a acessibilidade e a replicação. Ao utilizar
                            plataformas de código aberto como o <strong>ESP-32</strong>, eliminamos os custos
                            proibitivos associados a controladores industriais proprietários.
                        </p>
                        <p class="text-gray-300 leading-relaxed">
                            Essa estratégia permite que o sistema completo — englobando múltiplos sensores e
                            conectividade Wi-Fi — seja implementado por uma fração do valor de mercado das soluções
                            convencionais. Além disso, o uso de cases impressas em 3D e componentes padronizados garante
                            manutenção simplificada e peças de reposição baratas.
                        </p>
                    </div>
                </div>

                <!-- Lista de Benefícios Econômicos -->
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-slate-800/50 rounded-lg">
                        <div
                            class="w-10 h-10 rounded-full bg-green-900/50 flex items-center justify-center text-green-400 shrink-0">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Custo Reduzido</h4>
                            <p class="text-gray-400 text-sm">Investimento inicial drasticamente menor em comparação a
                                sistemas importados.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-slate-800/50 rounded-lg">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-900/50 flex items-center justify-center text-blue-400 shrink-0">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Manutenção Acessível</h4>
                            <p class="text-gray-400 text-sm">Peças encontradas facilmente no mercado nacional de
                                eletrônica.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-slate-800/50 rounded-lg">
                        <div
                            class="w-10 h-10 rounded-full bg-purple-900/50 flex items-center justify-center text-purple-400 shrink-0">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Escalabilidade</h4>
                            <p class="text-gray-400 text-sm">Adicione novos módulos sem precisar trocar a central de
                                controle.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEÇÃO CONCORRENTES (Revisada) -->
    <section id="concorrentes" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-slate-800 mb-4">Vantagem Competitiva</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Comparativo técnico e funcional.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Concorrente A -->
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-500 text-lg mb-4">Soluções Básicas</h3>
                    <div class="mb-4 text-orange-600 font-bold bg-orange-100 inline-block px-3 py-1 rounded text-sm">
                        Custo Médio</div>
                    <ul class="space-y-3 text-sm text-gray-500 mb-6">
                        <li class="flex items-center"><i
                                class="fa-solid fa-xmark text-red-400 mr-2 w-5"></i>Monitoramento isolado (só temp)
                        </li>
                        <li class="flex items-center"><i class="fa-solid fa-xmark text-red-400 mr-2 w-5"></i>Sem
                            histórico de dados</li>
                        <li class="flex items-center"><i class="fa-solid fa-xmark text-red-400 mr-2 w-5"></i>Sem
                            conexão Wi-Fi</li>
                    </ul>
                </div>

                <!-- AQUAMANAGER (Destaque) -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-cyan-500 transform md:-translate-y-2 relative">
                    <h3 class="font-bold text-cyan-600 text-xl mb-4">Aquamanager</h3>
                    <div class="mb-4 text-emerald-600 font-bold bg-emerald-100 inline-block px-3 py-1 rounded text-sm">
                        Melhor Custo-Benefício</div>
                    <p class="text-xs text-gray-400 mb-6">Tecnologia Open Source Integrada</p>

                    <ul class="space-y-3 text-sm text-gray-700 font-medium">
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-2 w-5"></i> pH +
                            Temp + Nível + Relé</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-2 w-5"></i> Acesso
                            Remoto Global</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-2 w-5"></i>
                            Totalmente Modular</li>
                    </ul>
                </div>

                <!-- Concorrente B -->
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-500 text-lg mb-4">Soluções Industriais</h3>
                    <div class="mb-4 text-red-600 font-bold bg-red-100 inline-block px-3 py-1 rounded text-sm">Alto
                        Investimento</div>
                    <ul class="space-y-3 text-sm text-gray-500 mb-6">
                        <li class="flex items-center"><i
                                class="fa-solid fa-check text-green-400 mr-2 w-5"></i>Precisão industrial</li>
                        <li class="flex items-center"><i class="fa-solid fa-xmark text-red-400 mr-2 w-5"></i>Hardware
                            Proprietário Fechado</li>
                        <li class="flex items-center"><i class="fa-solid fa-xmark text-red-400 mr-2 w-5"></i>Custo
                            proibitivo para pequenos produtores</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contato" class="bg-slate-900 text-white py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-water text-cyan-400 text-xl"></i>
                        <span class="font-bold text-lg">AQUAMANAGER</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Solução completa para automação de aquaponia.
                        Desenvolvido no âmbito do Mestrado em Engenharia (Unipampa).
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Links Rápidos</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#custos" class="hover:text-cyan-400 transition">Viabilidade</a></li>
                        <li><a href="#sensores" class="hover:text-cyan-400 transition">Detalhes Técnicos</a></li>
                        <li><a href="#" class="hover:text-cyan-400 transition">Sobre o Autor</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contato</h4>
                    <p class="text-gray-400 text-sm mb-2"><i
                            class="fa-solid fa-envelope mr-2"></i>contato@aquapampa.com</p>
                    <p class="text-gray-400 text-sm"><i class="fa-solid fa-location-dot mr-2"></i>Alegrete, RS -
                        Brasil</p>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 text-center text-sm text-gray-500">
                &copy; 2025 Aquapampa. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <script>
        // --- Peixes e Bolhas ---
        function createFish() {
            const container = document.getElementById('fishContainer');
            const fishEmojis = ['🐟', '🐠', '🐡', '🦈'];
            for (let i = 0; i < 15; i++) {
                const fish = document.createElement('div');
                fish.classList.add('fish');
                fish.innerText = fishEmojis[Math.floor(Math.random() * fishEmojis.length)];
                fish.style.top = Math.random() * 100 + '%';
                const duration = 10 + Math.random() * 15;
                fish.style.animationDuration = duration + 's';
                fish.style.animationDelay = (Math.random() * 20) * -1 + 's';
                const size = 1 + Math.random() * 2;
                fish.style.fontSize = size + 'rem';
                container.appendChild(fish);
            }
        }

        function createBubbles() {
            const container = document.getElementById('bubblesContainer');
            for (let i = 0; i < 30; i++) {
                const bubble = document.createElement('div');
                bubble.classList.add('bubble');
                const size = Math.random() * 10 + 5 + 'px';
                bubble.style.width = size;
                bubble.style.height = size;
                bubble.style.left = Math.random() * 100 + '%';
                const duration = 5 + Math.random() * 10;
                bubble.style.animationDuration = duration + 's';
                bubble.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(bubble);
            }
        }

        // --- Lógica do Diagrama do Sistema ---
        const componentData = {
            'tank': {
                title: 'Tanque de Peixes (Aquicultura)',
                icon: 'fa-fish',
                color: 'bg-blue-100 text-blue-600',
                desc: 'Onde ficam as tilápias. Os peixes produzem amônia através de seus dejetos. O sistema mantém a temperatura controlada (ideal 25-30°C).',
                hasData: true
            },
            'growbed': {
                title: 'Cama de Cultivo (Hidroponia)',
                icon: 'fa-seedling',
                color: 'bg-emerald-100 text-emerald-600',
                desc: 'As plantas (alface, temperos) filtram a água absorvendo nitratos. A água volta limpa para o tanque, criando um ciclo sustentável.',
                hasData: false
            },
            'pump': {
                title: 'Bomba de Recirculação',
                icon: 'fa-fan',
                color: 'bg-gray-200 text-gray-700',
                desc: 'Bomba de 3500L/h (35W) controlada pelo Relé. Eleva a água do tanque para as plantas.',
                hasData: false
            },
            'controller': {
                title: 'Controlador ESP-32',
                icon: 'fa-microchip',
                color: 'bg-yellow-100 text-yellow-600',
                desc: 'Dual-Core 32-bit com Wi-Fi/Bluetooth. Processa dados dos sensores e envia para a nuvem.',
                hasData: true
            }
        };

        function selectComponent(id) {
            const data = componentData[id];
            document.getElementById('info-title').innerText = data.title;
            document.getElementById('info-desc').innerText = data.desc;
            const iconDiv = document.getElementById('info-icon');
            iconDiv.className =
                `w-12 h-12 rounded-full flex items-center justify-center text-xl transition-all duration-300 ${data.color}`;
            iconDiv.innerHTML = `<i class="fa-solid ${data.icon}"></i>`;

            const liveDataDiv = document.getElementById('live-data');
            if (data.hasData) {
                liveDataDiv.classList.remove('hidden');
                liveDataDiv.classList.add('block');
            } else {
                liveDataDiv.classList.add('hidden');
            }
        }

        // --- Lógica dos Detalhes dos Sensores ---
        const sensorDetails = {
            'ph': {
                title: 'Sensor de pH (pH4502C)',
                icon: 'fa-flask',
                color: 'text-purple-600',
                desc: 'Mede a acidez da água. O pH incorreto bloqueia a absorção de nutrientes pelas plantas e estressa os peixes. O sensor BNC analógico permite leitura contínua de 0 a 14.',
                range: '6.0 - 7.5 pH',
                func: 'Saúde Bactérias Nitrificantes'
            },
            'temp': {
                title: 'Sensor de Temperatura (DS18B20)',
                icon: 'fa-temperature-full',
                color: 'text-orange-600',
                desc: 'Modelo à prova d\'água. A temperatura afeta o metabolismo dos peixes (apetite e excreção) e a oxigenação da água. Variações bruscas são letais.',
                range: '25°C - 30°C',
                func: 'Controle Metabólico'
            },
            'level': {
                title: 'Sensor Ultrassônico (HC-SR04)',
                icon: 'fa-ruler-vertical',
                color: 'text-blue-600',
                desc: 'Mede a distância até a lâmina d\'água usando ondas sonoras. Essencial para detectar vazamentos catastróficos ou falha na bomba antes que o tanque seque.',
                range: 'Nível Constante',
                func: 'Segurança / Anti-Seca'
            },
            'relay': {
                title: 'Módulo Relé 1 Canal',
                icon: 'fa-power-off',
                color: 'text-gray-700',
                desc: 'Atua como um interruptor digital para equipamentos de alta tensão (220V), permitindo que o ESP32 (3.3V) ligue ou desligue a bomba principal de 3500L/h.',
                range: 'On / Off',
                func: 'Controle de Atuadores'
            }
        };

        function showSensor(id) {
            // Update Active State Visuals
            document.querySelectorAll('.sensor-card').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('bg-white', 'shadow-md', 'border-l-4', 'border-cyan-600');
            });
            const activeBtn = document.getElementById(`btn-${id}`);
            activeBtn.classList.add('active');

            // Update Content
            const data = sensorDetails[id];
            const container = document.getElementById('sensor-detail-container');

            // Simple fade effect
            container.style.opacity = '0.5';
            setTimeout(() => {
                document.getElementById('detail-title').innerText = data.title;
                document.getElementById('detail-desc').innerText = data.desc;
                document.getElementById('detail-range').innerText = data.range;
                document.getElementById('detail-func').innerText = data.func;

                const icon = document.getElementById('detail-icon');
                icon.className = `fa-solid ${data.icon} text-4xl ${data.color}`;

                container.style.opacity = '1';
            }, 150);
        }

        window.addEventListener('DOMContentLoaded', () => {
            createFish();
            createBubbles();
        });
    </script>
</body>

</html>
