function changing() {
    alert('kek');
}

function fillName(value, name) {
    document.getElementsByName('name')[0].setAttribute('value', '');
    document.getElementsByName('name')[0].contentEditable = true;
    switch (value) {
        case '1':
            document.getElementsByName('name')[0].setAttribute('value', name);
            document.getElementsByName('name')[0].contentEditable = false;
            break;

        case '2':
            document.getElementsByName('name')[0].setAttribute('placeholder', 'User Email');
            break;

        case '3':
            document.getElementsByName('name')[0].setAttribute('placeholder', 'Group Name');
            break;
    }
}