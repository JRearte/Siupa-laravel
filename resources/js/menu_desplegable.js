document.querySelectorAll('.dropbtn').forEach(button => {
    button.addEventListener('click', function () {
        const dropdownContent = this.nextElementSibling;

        dropdownContent.classList.toggle('show');

        this.classList.toggle('selected');

        document.querySelectorAll('.dropdown-content').forEach(content => {
            if (content !== dropdownContent) {
                content.classList.remove('show');
            }
        });

        document.querySelectorAll('.dropbtn').forEach(otherButton => {
            if (otherButton !== this) {
                otherButton.classList.remove('selected');
            }
        });
    });
});


document.addEventListener('click', function (event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.classList.remove('show');
        });

        document.querySelectorAll('.dropbtn').forEach(button => {
            button.classList.remove('selected');
        });
    }
});

