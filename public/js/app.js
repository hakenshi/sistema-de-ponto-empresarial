const clock = document.querySelector('#clock');
const ponto = document.querySelector('#bater-ponto');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const disabledDuration = 5 * 60 * 1000;
setInterval(() => {
    const now = new Intl.DateTimeFormat('pt-br', {
        timeStyle: 'short',
    }).format(new Date());
    clock.innerText = `${now}`;
}, 1000)

const disableButton = () => {
    ponto.disabled = true;
    const disabledTime = new Date().getTime() + disabledDuration;
    localStorage.setItem('disabledDuration', disabledTime);
    setInterval(enableButton, disabledTime);
}

const enableButton = () => {
    ponto.disabled = false;
    localStorage.removeItem('disabledDuration');
}

const checkButtonState = () => {
    const disabledTime = localStorage.getItem('disabledDuration');
    if (disabledTime) {
        const currentTime = new Date().getTime();
        if (currentTime < disabledTime) {
            ponto.disabled = true;
            setTimeout(enableButton, disabledTime - currentTime);
        }
        else{
            enableButton();
        }
    }
}

ponto.addEventListener('click', () => {
    if (localStorage.getItem('disabledDuration')) {
        const remainingTime = parseInt(localStorage.getItem('disabledDuration')) - new Date().getTime();
        const remainingMinutes = Math.ceil(remainingTime / (60 * 1000));
        alert(`Por favor aguarde ${remainingMinutes} minutos antes de bater outro ponto`)
        return
    }

    fetch('/api/pontos/bater-ponto', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        }
    }).then(respose => {
        if (respose.ok) {
            return respose.json();
        }

        return respose.json().then(err => {
            throw new Error(err.message);
        });

    }).then((json) => {
        if (json.message) {
            console.log(json)
            alert(json.message);
        }
        document.querySelector("#ultimo-ponto").innerHTML = json.data.data_hora_saida ? json.data.data_hora_saida : json.data.data_hora_entrada;
        disableButton();
    }).catch((e) => {
        console.error(e);
    })
})
checkButtonState();