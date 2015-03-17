<style>
    footer {
        width: 100%;
        position: relative;
        margin-top: -360px; /* negative value of footer height */
        clear:both;
        padding-top:20px;
        background: url("/img/pie/pie9.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
        *zoom: 1;
        height: 360px;
        -webkit-box-shadow: inset 0 1px 0 #ffffff;
        -moz-box-shadow: inset 0 1px 0 #ffffff;
        box-shadow: inset 0 1px 0 #ffffff;
        font-family: fontHeader;
        text-align: center;
        color: #000000;
    }

    footer a {
        color: #ffffff;
    }

    footer a:HOVER {
        color: #000000;
    }

    footer .logo-sao {
        margin-top: 100px;
    }

    footer .logo-sao h4 {
        color: #ffffff;
        margin-top: 40px;
    }

    footer .segundo {
        margin-top: 180px;
        font-size: 20px;
    }

    footer .creative-commons {
        text-align: center;
        margin-top: 160px;
    }

    footer .row-fluid [class*="span"] {
        margin-left: 0;
    }

    div.segundo {
        padding-top: 10px;
    }

    @media (max-width: 800px) {
        footer div.creative-commons-text {
            display: none;
        }
        footer .logo-sao img {
            height: 100px;
        }
        footer .segundo {
            margin-top: 0;
            font-size: 14px;
        }
        footer .creative-commons {
            margin-top: 40px;
        }
        footer .logo-sao h4 {
            margin-top: 0;
        }
    }

    @media (max-width: 600px) {
        footer .segundo {
            margin-top: 0;
            font-size: 14px;
        }

        footer div.creative-commons-text {
            display: none;
        }

        footer .logo-sao img {
            height: 80px;
        }
        footer .creative-commons {
            margin-top: 40px;
        }
        footer .logo-sao h4 {
            margin-top: 0;
        }
    }


</style>

<footer>
    <div class="row-fluid">
        <div class="span2 logo-sao">
            <a title="www.sao.albacete.org" href="http://www.sao.albacete.org/" target="_blank">
                <img src="/img/logos/logo_sao_180x179" alt="Logotipo de la Sociedad Albacetense de Ornitología">
            </a>
            <h4>Versión 1.1.0</h4>
        </div>
        <div class="span5 segundo">
            <a href="/pages/elanuario/"><?=__("El Anuario");?></a> | 
            <a href="/pages/lasao/"><?=__("La SAO");?></a> | 
            <a href="/pages/elequipo/"><?=__("El Equipo");?></a> | 
            <a href="#modalAvisoLegal" data-toggle="modal"><?=__("Aviso Legal");?></a> |
            <a href="/pages/contacto/"><?=__("Contacto");?></a>
        </div>
        <div class="span5 creative-commons">
            <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">
                <img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
            </a>
            <div class="creative-commons-text">
                <br />
                <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Anuario Ornitológico de Albacete</span>
                por
                <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.sao.albacete.org" property="cc:attributionName" rel="cc:attributionURL" target="_blank">
                    Sociedad Albacetense de Ornitología</a> se distribuye bajo una
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank">
                    Licencia Creative Commons Atribución-NoComercial-SinDerivar 4.0 Internacional
                </a>.
            </div>
        </div>
    </div>
</footer>

<!-- Ventana de información de terminos y condiciones de uso -->
<div id="modalAvisoLegal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalAvisoLegalLabel" aria-hidden="true" style="text-align: justify;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h3 id="modalAvisoLegalLabel"><?=__("Términos y condiciones de uso");?></h3>
    </div>
    <div class="modal-body">
        <?=$this->element('avisoLegal'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>