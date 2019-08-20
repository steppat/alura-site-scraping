<?php

    function createCard($page, $limit = 10){

        $dados = callAPI("GET", "http://alura-scraping.herokuapp.com/produtos?_page=".$page."&_limit=".$limit);

        $response = '';
        for($i = 0; $i < count($dados); $i++){
            $opportunity = $dados[$i]['opportunity'] == 1 ? '<p class="txt-opportunity badge badge-danger inline">OPORTUNIDADE</p>' : '';
            $categoria = $dados[$i]['categoria'] == 1 ? "NOVO" : "USADO";
            $response .= '
                <div class="well card">
                    <div class="col-md-3 image-card">
                        <img width="220" height="155" alt="Foto" src="' . $dados[$i]['images'][0] . '">
                    </div>
                    <div class="col-md-6 body-card">
                        <p class="txt-name inline">' . $dados[$i]['name'] . '</p>
                            <p class="txt-category badge badge-secondary inline">' . $categoria . '</p>
                            ' . $opportunity . '
                        <p class="txt-motor">' . $dados[$i]['motor'] . '</p>
                        <p class="txt-description">Ano ' . $dados[$i]['year'] . ' - ' . number_format($dados[$i]['mileage'], 0, ',', '.') . ' km</p>
                        <ul class="lst-items">
                            <li class="txt-items">► ' . $dados[$i]['items'][0] . '</li>
                            <li class="txt-items">► ' . $dados[$i]['items'][1] . '</li>
                            <li class="txt-items">► ' . $dados[$i]['items'][2] . '</li>
                            <li class="txt-items">► ' . $dados[$i]['items'][3] . '</li>
                            <li class="txt-items">...</li>
                        </ul>
                        <p class="txt-location">' . $dados[$i]['location'] . '</p>
                    </div>
                    <div class="col-md-3 value-card">
                        <div class="value">
                            <p class="txt-value">R$ ' . number_format($dados[$i]['value'], 0, ',', '.') . '</p>
                        </div>
                    </div>
                </div>';
        }

        $dados = callAPI("GET", "http://alura-scraping.herokuapp.com/produtos");

        return array($response, count($dados));
    }

?>