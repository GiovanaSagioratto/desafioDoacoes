<?php
// Iniciar a sessão, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Exibir mensagem de sessão, se existir
if (isset($_SESSION['mensagem'])) {
    echo '<p>' . $_SESSION['mensagem'] . '</p>';
    unset($_SESSION['mensagem']);
}

// Autoload do Composer
require __DIR__ . '/../vendor/autoload.php';

// Obter o tipo de usuário da sessão
$tipoUsuario = $_SESSION['tipo_usuario'] ?? null;
?>

<!-- HTML da sidebar -->
<div class="sidebar-container">
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    <!-- Links comuns a todos os usuários -->
                    <li>
                        <a href="/desafioDoacoes/dashboard.php">
                            <i class="ti-home"></i><span>Início</span>
                        </a>
                    </li>

                    <?php if ($tipoUsuario === 'admin'): ?>
                        <!-- Menu do ADMIN -->
                        <li>
                            <a href="/desafioDoacoes/includes/validacao.php">
                                <i class="ti-check-box"></i><span>Validações</span>
                            </a>
                        </li>
                        <li>
                            <a href="/desafioDoacoes/includes/cadastro_organizador.php">
                                <i class="ti-user"></i><span>Cadastrar suportes</span>
                            </a>
                        </li>
                        <li>
                            <a href="/desafioDoacoes/dashboards/relatorios.php">
                                <i class="ti-bar-chart"></i><span>Relatórios</span>
                            </a>
                        </li>

                    <?php elseif ($tipoUsuario === 'organizador'): ?>
                        <!-- Menu do ORGANIZADOR -->
                        <li>
                            <a href="/desafioDoacoes/includes/gerenciar.php">
                                <i class="ti-clipboard"></i><span>Gerenciar doações</span>
                            </a>
                        </li>

                    <?php elseif ($tipoUsuario === 'comum'): ?>
                        <!-- Menu do USUÁRIO COMUM -->
                        <li>
                            <a href="/desafioDoacoes/includes/nova_doacao.php">
                                <i class="ti-plus"></i><span>Nova Doação</span>
                            </a>
                        </li>
                        <li>
                            <a href="/desafioDoacoes/includes/minhas_doacoes.php">
                                <i class="ti-list"></i><span>Minhas Doações</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Botão de sair -->
                    <li>
                        <a href="/desafioDoacoes/logout.php">
                            <i class="ti-power-off"></i><span>Sair</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>