(function (){

    var actualizarHora = function (){
        var fecha = new Date(),
            horas = fecha.getHours(),
            ampm,
            minutos = fecha.getMinutes(),
            segundos = fecha.getSeconds(),
            diaSemana = fecha.getDay(),
            dia = fecha.getDate(),
            mes = fecha.getMonth(),
            year = fecha.getFullYear();

        var pHoras = document.getElementById("horas"),
            pAMPM = document.getElementById("ampm"),
            pMinutos = document.getElementById("minutos"),
            pSegundos = document.getElementById("segundos"),
            pDiaSemana = document.getElementById("diaSemana"),
            pDia = document.getElementById("dia"),
            pMes = document.getElementById("mes"),
            pYear = document.getElementById("year");

        var semana = ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'];

        var meses = ['Gener' ,'Febrer','Març','Abril','Maig','Juny','Juliol','Agost','Setembre','Octubre','Novembre','Desembre']

        if (horas => 12){
            //horas = horas - 12;
            ampm = 'PM';
        }else{
            ampm = 'AM';
        }
        if (horas == 0) {
            horas = 12;
        }
        console.log(pDiaSemana);
        pDiaSemana.textContent = semana[diaSemana];
        pDia.textContent = dia ;
        pMes.textContent = meses[mes];
        pYear.textContent = year;
        pAMPM.textContent=ampm;
        pHoras.textContent = (horas > 0 && horas < 10 ? "0":"") + horas;

        pMinutos.textContent = (minutos < 10 ? "0":"") + minutos;
        pSegundos.textContent = (segundos < 10 ? "0":"") + segundos;

    };

    var intervalo = setInterval(actualizarHora, 1000);

    actualizarHora();
}())

