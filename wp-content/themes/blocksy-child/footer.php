<?php
/**
 * Universal Footer for Blocksy Child - Portal Mercado Erótico
 */
blocksy_after_current_template();
do_action('blocksy:content:bottom');
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
                    <a href="https://www.youtube.com/@canalmercadoerotico4514" target="_blank" rel="noopener" class="social-icon youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=5562982763039" target="_blank" rel="noopener" class="social-icon whatsapp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Coluna 2: Navegação Rápida -->
            <div class="footer-col">
                <h4 class="footer-heading">Navegação</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/'); ?>">Início</a></li>
                    <li><a href="<?php echo home_url('/sobre/'); ?>">Sobre Nós</a></li>
                    <li><a href="<?php echo home_url('/colunistas/'); ?>">Colunistas Oficiais</a></li>
                    <li><a href="<?php echo home_url('/agenda/'); ?>"><strong style="color:#e31c61;">Agenda do Mercado Erótico</strong></a></li>
                    <li><a href="<?php echo home_url('/acervo/'); ?>">Acervo Histórico (Desde 2018)</a></li>
                    <li><a href="<?php echo home_url('/livraria/'); ?>">Livraria Digital</a></li>
                    <li><a href="<?php echo home_url('/contato/'); ?>">Contatos & Redação</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Especialidades & Profissionais -->
            <div class="footer-col">
                <h4 class="footer-heading">Especialidades & Guia</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo home_url('/profissionais-especialistas-em-sexualidade/'); ?>"><i class="fas fa-user-md" style="color:#e31c61; margin-right:5px;"></i> <strong>Guia de Profissionais</strong></a></li>
                    <li><a href="<?php echo home_url('/agenda/'); ?>"><i class="far fa-calendar-alt" style="color:#e31c61; margin-right:5px;"></i> Calendário de Eventos Mundiais</a></li>
                    <li><a href="<?php echo home_url('/categoria/negocios/'); ?>">Negócios & SexShop</a></li>
                    <li><a href="<?php echo home_url('/categoria/sexologia/'); ?>">Sexologia & Saúde</a></li>
                    <li><a href="<?php echo home_url('/categoria/eventos/'); ?>">Eventos & Feiras</a></li>
                    <li><a href="https://www.guiadesexshop.com.br/" target="_blank" rel="noopener">Guia de Sex Shop <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i></a></li>
                </ul>
            </div>

            <!-- Coluna 4: Canais & Atendimento -->
            <div class="footer-col">
                <h4 class="footer-heading">Imprensa & Contato</h4>
                <p class="footer-contact-info"><i class="fas fa-envelope"></i> contato@mercadoerotico.org</p>
                <p class="footer-contact-info"><a href="https://api.whatsapp.com/send?phone=5562982763039" target="_blank" rel="noopener" style="color:inherit; text-decoration:none;"><i class="fab fa-whatsapp"></i> WhatsApp Comercial</a></p>
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
