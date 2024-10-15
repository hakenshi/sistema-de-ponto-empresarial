export const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

export function getFormEntries(ref){
    const form = Array.from(ref.elements)

    return form.reduce((acc, input) => {
        const name = input.name
        const value = input.value
        if (name) {
            acc[name] = value
        }
        return acc
    }, {})
}

export function renderErrorMessage(ref, errors) {
    ref.querySelectorAll('.text-danger').forEach(msg => msg.remove());

    if (errors && Object.keys(errors).length > 0) {
        Object.keys(errors).forEach(field => {
            const input = ref.querySelector(`[name="${field}"]`);

            if (input) {
                const errorMessage = errors[field][0];
                const errorElement = document.createElement('div');
                errorElement.classList.add('text-danger');
                errorElement.textContent = errorMessage;
                input.parentNode.insertBefore(errorElement, input.nextSibling);
            }
        });
    } else {
        console.log(errors);
    }
}

export function handleRequest(method, url, data, ref, headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
}) {
    const requestOptions = {
        method,
        headers
    }

    const methods = ['POST', 'PUT', 'DELETE', 'PATCH', 'GET'];

    if (!methods.includes(method.toUpperCase())) {
        return {
            message: `${method} is not valid`,
        }
    }
    if (data) {
        requestOptions.body = JSON.stringify(data);
    }

    return fetch(url, {
        method: requestOptions.method,
        headers: requestOptions.headers,
        body: requestOptions.body
    }).then((response) => {
        if (!response.ok) {
            return response.json().then(data => {
                throw data;
            });
        }
        return response;
    }).catch(({errors}) => {
        if (errors) {
            renderErrorMessage(ref, errors);
        }
    });
}