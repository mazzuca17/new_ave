$(document).ready(function() {
    function clickcaja(e) {
      var lista = $(this).find("ul"), triangulo = $(this).find("span:last-child");
      e.preventDefault();
      $(this).find("ul").toggle();
        if(lista.is(":hidden")) {
            triangulo.removeClass("triangulosup").addClass("trianguloinf");
        }
        else {
            triangulo.removeClass("trianguloinf").addClass("triangulosup");
        }
    }

    function clickli(e) {
      var comercialBD = document.getElementById('paises');
      var texto = $(this).text(),
        seleccionado = $(this).parent().prev(),
            lista = $(this).closest("ul"),
            triangulo = $(this).parent().next();
      e.preventDefault();
      e.stopPropagation();	

      seleccionado.text(texto);
      seleccionado.val(texto);
      comercialBD.value = texto;
      

        lista.hide();
        triangulo.removeClass("triangulosup").addClass("trianguloinf");
    }

    $(".paises_select").click(clickcaja);
    $(".paises_select").on("click", "li", clickli);

    

  });