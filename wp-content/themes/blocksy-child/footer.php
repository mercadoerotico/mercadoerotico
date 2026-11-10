<?php
/**
 * Universal Footer for Blocksy Child - Portal Mercado Erótico
 */
?>
    </main>
</div><!-- #main-container -->

<footer class="me-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <!-- Coluna 1: Logo e Bio -->
            <div class="footer-col footer-brand">
                <a href="<?php echo home_url('/'); ?>" class="footer-logo-link">
                    <img src="https://mercadoerotico-org-901765.hostingersite.com/wp-content/uploads/2022/10/Copia-de-Julianna-Santos-10.png" alt="Mercado Erótico" class="footer-logo-img">
                </a>
                <p class="footer-bio">O principal portal jornalístico, analítico e documental sobre o mercado íntimo, saúde sexual e bem-estar no Brasil. Cobertura especializada contínua desde 2018.</p>
                <div class="footer-social-links">
                    <a href="https://www.instagram.com/mercadoerotico/" target="_blank" rel="noopener" class="social-icon instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/mercadoerotico/" target="_blank" rel="noopener" class="social-icon facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/@mercadoerotico" target="_blank" rel="noopener" class="social-icon youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=5511999999999" target="_blank" rel="noopener" class="social-icon whatsapp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Coluna 2: Navegação Rápida -->
            <div class="footer-col">
                <h4 class="footer-heading">Navegação</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/'); ?>">Início</a></li>
                    <li><a href="<?php echo home_url('/sobre/'); ?>">Sobre Nós</a></li>
                    <li><a href="<?php echo home_url('/acervo/'); ?>">Acervo Histórico (Desde 2018)</a></li>
                    <li><a href="<?php echo home_url('/livraria/'); ?>">Livraria Digital</a></li>
                    <li><a href="<?php echo home_url('/contato/'); ?>">Contatos</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Especialidades & Mercado -->
            <div class="footer-col">
                <h4 class="footer-heading">Editorias & Destaques</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/categoria/negocios/'); ?>">Negócios & SexShop</a></li>
                    <li><a href="<?php echo home_url('/categoria/sexologia/'); ?>">Sexologia & Saúde</a></li>
                    <li><a href="<?php echo home_url('/categoria/eventos/'); ?>">Eventos & Feiras</a></li>
                    <li><a href="<?php echo home_url('/profissionais-especialistas-em-sexualidade/'); ?>">Guia de Profissionais</a></li>
                    <li><a href="https://www.guiadesexshop.com.br/" target="_blank" rel="noopener">Guia de Sex Shop</a></li>
                </ul>
            </div>

            <!-- Coluna 4: Canais & Atendimento -->
            <div class="footer-col">
                <h4 class="footer-heading">Imprensa & Contato</h4>
                <p class="footer-contact-info"><i class="fas fa-envelope"></i> redacao@mercadoerotico.org</p>
                <p class="footer-contact-info"><i class="fas fa-shield-alt"></i> Portal Seguro & Auditado</p>
                <a href="<?php echo home_url('/contato/'); ?>" class="btn-footer-contact">Fale com a Redação</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong>Portal Mercado Erótico</strong>. Todos os direitos reservados. Material jornalístico e histórico protegido.</p>
            <p class="footer-madeby">Ambiente moderno de alto desempenho • Otimizado para Mobile</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
