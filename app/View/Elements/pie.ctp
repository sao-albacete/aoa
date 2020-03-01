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

<script>
    $(document).ready(function() {
        $('#citarAnuario').click(function(e) {
            e.preventDefault();
        });
        $('#citarAnuario').popover()
    });
</script>

<footer>
    <div class="row-fluid">
        <div class="span2 logo-sao">
            <a title="www.sao.albacete.org" href="http://www.sao.albacete.org/" target="_blank">
                <img src="/img/logos/logo_sao_180x179" alt="Logotipo de la Sociedad Albacetense de Ornitología">
            </a>
            <h4>Versión 1.1.1</h4>
        </div>
        <div class="span5 segundo">
            <a href="/pages/elanuario/"><?=__("El Anuario");?></a> | 
            <a href="/pages/lasao/"><?=__("La SAO");?></a> | 
            <a href="/pages/elequipo/"><?=__("El Equipo");?></a> | 
            <a href="/pages/aviso-legal/"><?=__("Aviso Legal");?></a> |
            <a href="/pages/contacto/"><?=__("Contacto");?></a>
        </div>
        <div class="span5 creative-commons">
            <a rel="license" href="/img/logos/cc-88x31.png" target="_blank">
                <img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
            </a>
            <div>
                <br />
                <a id="citarAnuario" href="#" data-original-title="<?=__('Cita recomendada')?>" data-toggle="popover" data-placement="top"
                   data-html="true" title=""
                   data-content="Sociedad Albacetense de Ornitología (S.A.O.). Anuario Ornitológico de Albacete online (AOA) [en línea]. Versión 1.1.0 [Albacete, España]. Sociedad Albacetense de Ornitología, 7 de diciembre de 2014 [fecha de consulta]. Disponible en Web: https://anuario.albacete.org/"><?=__('¿Cómo citar el anuario?')?></a>
            </div>
        </div>
    </div>
</footer>
