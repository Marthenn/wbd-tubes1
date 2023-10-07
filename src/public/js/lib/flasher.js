const make_flash = (message, type = 'info', left_button = null, left_button = null) => {
    const flash = document.createElement('div');
    flash.classList.add('flash-message');
    flash.classList.add('flash');

    const flash_container = document.createElement('div');
    flash_type = 'flash-' + type;
    flash_container.classList.add(flash_type);
    flash_container.classList.add(flash_type);

    const flash_message = document.createElement('p');
    flash_message.classList.add('flash-message-text');
    flash_message.innerHTML = message;

    const flash_buttons = document.createElement('div');
    flash_buttons.classList.add('flash-button');


    const right_button_element = document.createElement('button');
    right_button_element.classList.add('flash-message-right-button');
    right_button_element.innerHTML = right_button;

    if (left_button){
        const left_button_element = document.createElement('button');
        left_button_element.classList.add('flash-message-left-button');
        left_button_element.innerHTML = left_button;
        flash_buttons.appendChild(left_button_element);
    }
    flash_buttons.appendChild(right_button_element);

    flash_container.appendChild(flash_message);
    flash_container.appendChild(flash_buttons);

    flash.appendChild(flash_container);

    return flash;
}
