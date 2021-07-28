var arrQuestion = Array();
$(document).ready(function () {
    var numQuestion = 1;
    $('#add-question').on('click', function () {
        addQuestion(numQuestion);
        numQuestion += 1;
    });
    $('#submit-form').on('click', function () {
        submitForm();
    });
});

function addInputShortText() {
    return $('<div class="col-sm-5">' +
        '<input class="form-control form-control-user" type="text" placeholder="Contoh isian..." disabled>' +
        '</div>');
}

function addInputLongText() {
    return '<div class="col-sm-5">' +
        '<textarea class="form-control form-control-user" type="text" placeholder="Contoh isian..." disabled></textarea>' +
        '</div>';
}

function addInputDate() {
    return '<div class="col-sm-5">' +
        '<input class="form-control form-control-user" type="date" placeholder="Contoh isian..." disabled>' +
        '</div>';
}

function addInputCheckbox() {
    var checkbox = $('<div class="col-sm-5">' +
        '<div class="options">' +
        '</div>' +
        '<div class="button-flex-container mt-3">' +
        '<span class="divider">' +
        '</span>' +
        '<button id="add-option" class="btn btn-secondary btn-circle btn-sm ml-2 mr-2 add-option">' +
        '<i class="fas fa-plus"></i>' +
        '</button>' +
        '<span class="divider">' +
        '</span>' +
        '</div>' +
        '</div>');
    var checkboxItem = $('<div class="d-flex align-items-center mb-2">' +
        '<input class="mr-2" type="checkbox" disabled>' +
        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
        '<i class="bi bi-x"></i>' +
        '</button>' +
        '</div>');
    checkboxItem.find('.delete-option').on('click', function () {
        console.log('lol');
    });
    checkbox.find('.options').append(checkboxItem);
    checkbox.find('.add-option').on('click', function () {
        checkbox.find('.options').append(checkboxItem);
    });
    return checkbox;
}

function addInputRadio() {
    return '<div class="col-sm-5">' +
        '<div class="d-flex align-items-center mb-2">' +
        '<input class="mr-2" type="radio" disabled>' +
        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2">' +
        '<i class="bi bi-x"></i>' +
        '</button>' +
        '</div>' +
        '<div class="button-flex-container mt-3">' +
        '<span class="divider">' +
        '</span>' +
        '<button id="add-question" class="btn btn-secondary btn-circle btn-sm ml-2 mr-2">' +
        '<i class="fas fa-plus"></i>' +
        '</button>' +
        '<span class="divider">' +
        '</span>' +
        '</div>' +
        '</div>';
}

function addQuestion(questionID) {
    var question = new Question();
    var inputid = 1;
    question.id = questionID;
    preview =
        '<div class="row mt-2 preview" id="preview" data-previewid="' + questionID + '">' +
        '</div>';

    var select = $('<select type="dropdown" class="form-control form-control-user question-select" id="question-select" data-selectid="' + questionID + '">' +
        '<option value="choose">Pilih tipe pertanyaan...</option>' +
        '<option value="short-text">Isian Singkat</option>' +
        '<option value="par">Paragraf</option>' +
        '<option value="dropdown">Dropdown</option>' +
        '<option value="radio">Pilihan Ganda</option>' +
        '<option value="check">Ceklis</option>' +
        '<option value="date">Tanggal</option>' +
        "</select>").on('change', function () {
            let selectElement = $(this).attr('data-selectid');
            let preview = $('.preview[data-previewid="' + selectElement + '"]');
            let selectedValue = $(this).val();
            switch (selectedValue) {
                case "choose": {
                    preview.empty();
                    question.input = [];
                };
                    break;
                case "short-text": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputShortText());
                    var input = new Input();
                    input.type = InputType.Text;
                    question.input.push(input);
                };
                    break;
                case "par": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputLongText());
                    var input = new Input();
                    input.type = InputType.LongText;
                    question.input.push(input);
                };
                    break;
                case "radio": {
                    preview.empty();
                    question.input = [];
                    if (inputid > 1) {
                        inputid = 1;
                    }
                    var radiocircle = $('<div class="col-sm-5 radio-container">' +
                        '<div class="radio-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var radioItem = $('<div class="d-flex align-items-center mb-2" data-radioid="' + inputid + '">' +
                        '<input class="mr-2" type="radio" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    radioItem.find('.delete-option').on('click', function () {
                        $(radioItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-radioid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var radioItem2 = $('<div class="d-flex align-items-center mb-2" data-radioid="' + inputid + '">' +
                            '<input class="mr-2" type="radio" disabled>' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        radioItem2.find('.delete-option').on('click', function () {
                            $(radioItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-radioid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Radiobutton;
                        radioItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        radiocircle.find('.radio-options').append(radioItem2);
                    });
                    radiocircle.find('.radio-options').append(radioItem);
                    let input = new Input();
                    input.type = InputType.Radiobutton;
                    radioItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    radiocircle.append(btn);
                    preview.append(radiocircle);
                };
                    break;
                case "check": {
                    preview.empty();
                    question.input = [];
                    if (inputid > 1) {
                        inputid = 1;
                    }
                    var checkbox = $('<div class="col-sm-5 checkbox-container">' +
                        '<div class="checkbox-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var checkboxItem = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + inputid + '">' +
                        '<input class="mr-2" type="checkbox" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    checkboxItem.find('.delete-option').on('click', function () {
                        $(checkboxItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-checkboxid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var checkboxItem2 = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + inputid + '">' +
                            '<input class="mr-2" type="checkbox" disabled>' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        checkboxItem2.find('.delete-option').on('click', function () {
                            $(checkboxItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-checkboxid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Checkbox;
                        checkboxItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        checkbox.find('.checkbox-options').append(checkboxItem2);
                    });
                    checkbox.find('.checkbox-options').append(checkboxItem);
                    let input = new Input();
                    input.type = InputType.Checkbox;
                    checkboxItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    checkbox.append(btn);
                    preview.append(checkbox);
                };
                    break;
                case "dropdown": {
                    preview.empty();
                    question.input = [];
                    if (inputid > 1) {
                        inputid = 1;
                    }
                    var dropdown = $('<div class="col-sm-5 checkbox-container">' +
                        '<div class="dropdown-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var dropdownItem = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + inputid + '">' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    dropdownItem.find('.delete-option').on('click', function () {
                        $(dropdownItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-dropdownid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var dropdownItem2 = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + inputid + '">' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        dropdownItem2.find('.delete-option').on('click', function () {
                            $(dropdownItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-dropdownid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Dropdown;
                        dropdownItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        dropdown.find('.dropdown-options').append(dropdownItem2)
                    });
                    dropdown.find('.dropdown-options').append(dropdownItem);
                    let input = new Input();
                    input.type = InputType.Dropdown;
                    dropdownItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    dropdown.append(btn);
                    preview.append(dropdown);
                };
                    break;
                case "date": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputDate());
                    var input = new Input();
                    input.type = InputType.Date;
                    question.input.push(input);
                };
                    break;
            }
        });

    html_code =
        // legend_code +
        "<div class='row'>" +
        '<div class="col-md-8">' +
        "<input type='text' class='form-control form-control-user' id='question-title' placeholder='Pertanyaan...'>" +
        '</div>' +
        '<div class="col-md-4 dropdown">' +
        '</div>' +
        "</div>";

    delete_code =
        '<div>' +
        '<button class="btn-delete btn btn-danger btn-sm btn-circle mr-3">' +
        '<i class="fas fa-trash">' +
        '</i>' +
        '</button>' +
        '</div>';

    // required =
    //     '<div>' +
    //     '<input class="mr-2" type="checkbox" id="required-check">' +
    //     '<label class="mr-4" >Penting</label>' +
    //     '</div>';

    card_code =
        $('<div class="card border-left-primary shadow mt-3 question-card" data-questionid="' + questionID + '">' +
            '<div class="card-body">' +
            '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">' +
            html_code +
            preview +
            '</div>' +
            '<div class="button-flex-container mt-2 ">' +
            '<span class="divider">' +
            '</span>' +
            '</div>' +
            '<div class="row mt-2 float-right">' +
            // required +
            delete_code +
            '</div>' +
            '</div>' +
            '</div>');
    card_code.find('.dropdown').append(select);
    card_code.find('#required-check').on('change', function () {
        console.log('');
    })
    card_code.find('.btn-delete').on('click', function () {
        $('.question-card[data-questionid="' + questionID + '"]').animate({ height: 0 }, 150, function () {
            $(this).remove();
            for (i = 0; i < arrQuestion.length; i++) {
                if (arrQuestion[i].name == question.name && arrQuestion[i].id == question.id) {
                    arrQuestion.splice(i, 1);
                }
            }
        });
    })
    $('#question-section').append(card_code);
    card_code.find('#question-title').on('keyup', function () {
        question.question = $(this).val();
    });
    arrQuestion.push(question);
}

function editQuestion(questionID, type, questionText, inputItem) {
    var question = new Question();
    var inputid = 1;
    question.id = questionID;
    question.question = questionText;
    var preview =
        '<div class="row mt-2 preview" id="preview" data-previewid="' + questionID + '">' +
        '</div>';

    var select = $('<select type="dropdown" class="form-control form-control-user question-select" id="question-select" data-selectid="' + questionID + '">' +
        '<option value="choose">Pilih tipe pertanyaan...</option>' +
        '<option value="short-text">Isian Singkat</option>' +
        '<option value="par">Paragraf</option>' +
        '<option value="dropdown">Dropdown</option>' +
        '<option value="radio">Pilihan Ganda</option>' +
        '<option value="check">Ceklis</option>' +
        '<option value="date">Tanggal</option>' +
        "</select>").on('change', function () {
            let selectElement = $(this).attr('data-selectid');
            let preview = $('.preview[data-previewid="' + selectElement + '"]');
            let selectedValue = $(this).val();
            switch (selectedValue) {
                case "choose": {
                    preview.empty();
                    question.input = [];
                };
                    break;
                case "short-text": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputShortText());
                    var input = new Input();
                    input.type = InputType.Text;
                    question.input.push(input);
                };
                    break;
                case "par": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputLongText());
                    var input = new Input();
                    input.type = InputType.LongText;
                    question.input.push(input);
                };
                    break;
                case "radio": {
                    preview.empty();
                    question.input = [];
                    // if (inputid > 1) {
                    //     inputid = 1;
                    // }
                    var radiocircle = $('<div class="col-sm-5 radio-container">' +
                        '<div class="radio-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var radioItem = $('<div class="d-flex align-items-center mb-2" data-radioid="' + inputid + '">' +
                        '<input class="mr-2" type="radio" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    radioItem.find('.delete-option').on('click', function () {
                        $(radioItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-radioid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var radioItem2 = $('<div class="d-flex align-items-center mb-2" data-radioid="' + inputid + '">' +
                            '<input class="mr-2" type="radio" disabled>' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        radioItem2.find('.delete-option').on('click', function () {
                            $(radioItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-radioid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Radiobutton;
                        radioItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        $('.radio-options').append(radioItem2)
                    });
                    radiocircle.find('.radio-options').append(radioItem);
                    let input = new Input();
                    input.type = InputType.Radiobutton;
                    radioItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    radiocircle.append(btn);
                    preview.append(radiocircle);
                };
                    break;
                case "check": {
                    preview.empty();
                    question.input = [];
                    // if (inputid > 1) {
                    //     inputid = 1;
                    // }
                    var checkbox = $('<div class="col-sm-5 checkbox-container">' +
                        '<div class="checkbox-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var checkboxItem = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + inputid + '">' +
                        '<input class="mr-2" type="checkbox" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    checkboxItem.find('.delete-option').on('click', function () {
                        $(checkboxItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-checkboxid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var checkboxItem2 = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + inputid + '">' +
                            '<input class="mr-2" type="checkbox" disabled>' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        checkboxItem2.find('.delete-option').on('click', function () {
                            $(checkboxItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-checkboxid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Checkbox;
                        checkboxItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        $('.checkbox-options').append(checkboxItem2)
                    });
                    checkbox.find('.checkbox-options').append(checkboxItem);
                    let input = new Input();
                    input.type = InputType.Checkbox;
                    checkboxItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    checkbox.append(btn);
                    preview.append(checkbox);
                };
                    break;
                case "dropdown": {
                    preview.empty();
                    question.input = [];
                    // if (inputid > 1) {
                    //     inputid = 1;
                    // }                    
                    var dropdown = $('<div class="col-sm-5 checkbox-container">' +
                        '<div class="dropdown-options mt-1">' +
                        '</div>' +
                        '</div>');
                    var dropdownItem = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + inputid + '">' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    dropdownItem.find('.delete-option').on('click', function () {
                        $(dropdownItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-dropdownid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                        '<span class="divider">' +
                        '</span>' +
                        '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                        '<i class="fas fa-plus"></i>' +
                        '</button>' +
                        '<span class="divider divider-r">' +
                        '</span>' +
                        '</div>');
                    btn.find('.add-option').on('click', function () {
                        var dropdownItem2 = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + inputid + '">' +
                            '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                            '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                            '<i class="bi bi-x"></i>' +
                            '</button>' +
                            '</div>');
                        dropdownItem2.find('.delete-option').on('click', function () {
                            $(dropdownItem2).animate({ height: 0 }, 150, function () {
                                $(this).remove();
                                var txtToDelete = $(this).find('.option-text').val();
                                var idxToDelete = $(this).attr('data-dropdownid');
                                for (i = 0; i < question.input.length; i++) {
                                    if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                        question.input.splice(i, 1);
                                    }
                                }
                            });
                        });
                        let input = new Input();
                        input.type = InputType.Dropdown;
                        dropdownItem2.find('.option-text').on('keyup', function () {
                            input.text = $(this).val();
                        });
                        input.id = inputid;
                        question.input.push(input);
                        inputid += 1;
                        $('.dropdown-options').append(dropdownItem2)
                    });
                    dropdown.find('.dropdown-options').append(dropdownItem);
                    let input = new Input();
                    input.type = InputType.Dropdown;
                    dropdownItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    inputid += 1;
                    question.input.push(input);
                    dropdown.append(btn);
                    preview.append(dropdown);
                };
                    break;
                case "date": {
                    preview.empty();
                    question.input = [];
                    preview.append(addInputDate());
                    var input = new Input();
                    input.type = InputType.Date;
                    question.input.push(input);
                };
                    break;
            }
        });


    html_code =
        // legend_code +
        "<div class='row'>" +
        '<div class="col-md-8">' +
        "<input type='text' class='form-control form-control-user' id='question-title' placeholder='Pertanyaan...'>" +
        '</div>' +
        '<div class="col-md-4 dropdown">' +
        '</div>' +
        "</div>";

    delete_code =
        '<div>' +
        '<button class="btn-delete btn btn-danger btn-sm btn-circle mr-3">' +
        '<i class="fas fa-trash">' +
        '</i>' +
        '</button>' +
        '</div>';

    // required =
    //     '<div>' +
    //     '<input class="mr-2" type="checkbox" id="required-check">' +
    //     '<label class="mr-4" >Penting</label>' +
    //     '</div>';

    card_code =
        $('<div class="card border-left-primary shadow mt-3 question-card" data-questionid="' + questionID + '">' +
            '<div class="card-body">' +
            '<div class="text-xs font-weight-bold text-info text-uppercase mb-1">' +
            html_code +
            preview +
            '</div>' +
            '<div class="button-flex-container mt-2 ">' +
            '<span class="divider">' +
            '</span>' +
            '</div>' +
            '<div class="row mt-2 float-right">' +
            // required +
            delete_code +
            '</div>' +
            '</div>' +
            '</div>');
    card_code.find('.dropdown').append(select);
    card_code.find('#question-title').val(questionText);
    card_code.find('#required-check').on('change', function () {
        console.log('');
    })
    card_code.find('.btn-delete').on('click', function () {
        $('.question-card[data-questionid="' + questionID + '"]').animate({ height: 0 }, 150, function () {
            $(this).remove();
            for (i = 0; i < arrQuestion.length; i++) {
                if (arrQuestion[i].name == question.name && arrQuestion[i].id == question.id) {
                    arrQuestion.splice(i, 1);
                }
            }
        });
    });
    $('#question-section').append(card_code);
    card_code.find('#question-title').val(questionText);
    card_code.find('#question-title').on('keyup', function () {
        question.question = $(this).val();
    });

    if (type != undefined || type != null) {
        // let selectElement = select.attr('data-selectid');
        let preview = card_code.find('#preview');
        // let selectedValue = $(this).val();
        switch (type) {
            case (InputType.Text): {
                select.val('short-text');
                preview.empty();
                question.input = [];
                preview.append(addInputShortText());
                var input = new Input();
                input.type = InputType.Text;
                question.input.push(input);
            };
                break;
            case (InputType.LongText): {
                select.val('par');
                preview.empty();
                question.input = [];
                preview.append(addInputLongText());
                var input = new Input();
                input.type = InputType.LongText;
                question.input.push(input);
            };
                break;
            case (InputType.Date): {
                    select.val('date');
                    preview.empty();
                    question.input = [];
                    preview.append(addInputDate());
                    var input = new Input();
                    input.type = InputType.Date;
                    question.input.push(input);
                };
                    break;
            case (InputType.Checkbox): {
                select.val('check');
                preview.empty();
                question.input = [];
                if (inputid > 1) {
                    inputid = 1;
                }
                var checkbox = $('<div class="col-sm-5 checkbox-container">' +
                    '<div class="checkbox-options mt-1" data-questionid="'+question.id+'">' +
                    '</div>' +
                    '</div>');
                inputItem.forEach(function (item) {
                    let input = new Input();
                    input.type = InputType.Checkbox;
                    input.id = item.id;
                    input.text = item.text
                    
                    var checkboxItem = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + item.id + '">' +
                        '<input class="mr-2" type="checkbox" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    checkboxItem.find('.option-text').val(item.text);
                    checkboxItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    question.input.push(input);
                    checkboxItem.find('.delete-option').on('click', function () {
                        $(checkboxItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-checkboxid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    checkbox.find('.checkbox-options').append(checkboxItem);
                    // input.id = inputid;
                    inputid = input.id;
                });
                inputid++;
                var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                    '<span class="divider">' +
                    '</span>' +
                    '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                    '<i class="fas fa-plus"></i>' +
                    '</button>' +
                    '<span class="divider divider-r">' +
                    '</span>' +
                    '</div>');
                btn.find('.add-option').on('click', function () {
                    var checkboxItem2 = $('<div class="d-flex align-items-center mb-2" data-checkboxid="' + inputid + '">' +
                        '<input class="mr-2" type="checkbox" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    checkboxItem2.find('.delete-option').on('click', function () {
                        $(checkboxItem2).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-checkboxid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    let input = new Input();
                    input.type = InputType.Checkbox;
                    checkboxItem2.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    question.input.push(input);
                    inputid += 1;
                    checkbox.find('.checkbox-options').append(checkboxItem2);
                });
                checkbox.append(btn);
                // question.input.push(input);
                preview.append(checkbox);
            };
                break;
            case (InputType.Dropdown): {
                select.val('dropdown');
                preview.empty();
                question.input = [];
                if (inputid > 1) {
                    inputid = 1;
                }
                var dropdown = $('<div class="col-sm-5 dropdown-container">' +
                    '<div class="dropdown-options mt-1">' +
                    '</div>' +
                    '</div>');
                inputItem.forEach(function (item) {
                    let input = new Input();
                    input.type = InputType.Dropdown;
                    input.id = item.id;
                    input.text = item.text;
                    
                    var dropdownItem = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + item.id + '">' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    dropdownItem.find('.option-text').val(item.text);
                    dropdownItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    question.input.push(input);
                    dropdownItem.find('.delete-option').on('click', function () {
                        $(dropdownItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-dropdownid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    dropdown.find('.dropdown-options').append(dropdownItem);
                    inputid = input.id;
                });
                inputid += 1;
                var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                    '<span class="divider">' +
                    '</span>' +
                    '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                    '<i class="fas fa-plus"></i>' +
                    '</button>' +
                    '<span class="divider divider-r">' +
                    '</span>' +
                    '</div>');
                btn.find('.add-option').on('click', function () {
                    var dropdownItem2 = $('<div class="d-flex align-items-center mb-2" data-dropdownid="' + inputid + '">' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    dropdownItem2.find('.delete-option').on('click', function () {
                        $(dropdownItem2).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-dropdownid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    let input = new Input();
                    input.type = InputType.dropdown;
                    dropdownItem2.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    question.input.push(input);
                    inputid += 1;
                    dropdown.find('.dropdown-options').append(dropdownItem2);
                });
                dropdown.append(btn);
                // question.input.push(input);
                preview.append(dropdown);
            };
                break;
            case (InputType.Radiobutton): {
                select.val('radio');
                preview.empty();
                question.input = [];
                if (inputid > 1) {
                    inputid = 1;
                }
                var radio = $('<div class="col-sm-5 radio-container">' +
                    '<div class="radio-options mt-1">' +
                    '</div>' +
                    '</div>');
                inputItem.forEach(function (item) {
                    let input = new Input();
                    input.type = InputType.Dropdown;
                    input.id = item.id;
                    input.text = item.text;
                    
                    var radioItem = $('<div class="d-flex align-items-center mb-2" data-radioid="' + item.id + '">' +
                        '<input class="mr-2" type="radio" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    radioItem.find('.option-text').val(item.text);
                    radioItem.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    question.input.push(input);
                    radioItem.find('.delete-option').on('click', function () {
                        $(radioItem).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-radioid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    radio.find('.radio-options').append(radioItem);
                    inputid = input.id;
                    
                });
                inputid += 1;
                var btn = $('<div class="button-flex-container mt-1 mb-2">' +
                    '<span class="divider">' +
                    '</span>' +
                    '<button id="add-option" class="add-option btn btn-secondary btn-circle btn-sm ml-2 mr-2 ">' +
                    '<i class="fas fa-plus"></i>' +
                    '</button>' +
                    '<span class="divider divider-r">' +
                    '</span>' +
                    '</div>');
                btn.find('.add-option').on('click', function () {
                    var radioItem2 = $('<div class="d-flex align-items-center mb-2" data-radioid="' + inputid + '">' +
                        '<input class="mr-2" type="radio" disabled>' +
                        '<input class="option-text form-control md-5" type="text" placeholder="Contoh isian...">' +
                        '<button class="btn btn-secondary btn-secondary btn-circle btn-sm ml-2 mr-2 delete-option">' +
                        '<i class="bi bi-x"></i>' +
                        '</button>' +
                        '</div>');
                    radioItem2.find('.delete-option').on('click', function () {
                        $(radioItem2).animate({ height: 0 }, 150, function () {
                            $(this).remove();
                            var txtToDelete = $(this).find('.option-text').val();
                            var idxToDelete = $(this).attr('data-radioid');
                            for (i = 0; i < question.input.length; i++) {
                                if (question.input[i].text == txtToDelete && question.input[i].id == idxToDelete) {
                                    question.input.splice(i, 1);
                                }
                            }
                        });
                    });
                    let input = new Input();
                    input.type = InputType.radio;
                    radioItem2.find('.option-text').on('keyup', function () {
                        input.text = $(this).val();
                    });
                    input.id = inputid;
                    question.input.push(input);
                    inputid += 1;
                    radio.find('.radio-options').append(radioItem2);
                });
                radio.append(btn);
                preview.append(radio);
            };
                break;
        }
    }
    arrQuestion.push(question);
}

function renderCheckbox(preview, checkbox) {
    preview.empty();
    preview.append(checkbox);
}

function submitForm() {
    var form = new Form();
    var formTitle = $('#form-title').val();
    var formDescription = $('#form-description').val();
    if (!formTitle) {
        alert('Judul form wajib diisi');
        return;
    }
    if (arrQuestion.length == 0) {
        alert('Isikan pertanyaan');
        return;
    }
    form.name = formTitle;
    form.description = formDescription;
    for (i = 0; i < arrQuestion.length; i++) {
        arrQuestion[i].id = i + 1;
        arrQuestion[i].number = i + 1;
    }
    form.questions = arrQuestion;
    console.log(JSON.stringify(form));
    $.ajax({
        method: 'POST',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "https://www.puskesmas-sentolo2.com/formSend.php",
        data: JSON.stringify(form),
        success: function (data) {
            alert(data.ResponseMessage);
            if (data.ResponseCode == 0) {
                window.location = 'daftar-form.php';
            }
        },
        statusCode: {
            400: function () {
                alert('error');
            },
            500: function () {
                alert('server error');
            }
        }
    });
}

function editForm(formId) {
    var form = new Form();
    form.id = formId;
    var formTitle = $('#form-title').val();
    var formDescription = $('#form-description').val();
    if (!formTitle) {
        alert('Judul form wajib diisi');
        return;
    }
    if (arrQuestion.length == 0) {
        alert('Isikan pertanyaan');
        return;
    }
    form.name = formTitle;
    form.description = formDescription;
    for (i = 0; i < arrQuestion.length; i++) {
        arrQuestion[i].id = i + 1;
        arrQuestion[i].number = i + 1;
    }
    form.questions = arrQuestion;
    console.log(JSON.stringify(form));
    $.ajax({
        method: 'POST',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "https://www.puskesmas-sentolo2.com/formEdit.php",
        data: JSON.stringify(form),
        success: function (data) {
            alert(data.ResponseMessage);
            if (data.ResponseCode == 0) {
                window.location = 'daftar-form.php';
            }
        },
        statusCode: {
            400: function () {
                alert('error');
            },
            500: function () {
                alert('server error');
            }
        }
    });
}

function getResponseDataTable(formId) {
    var data,
        tableName = '#dataTable',
        columns,
        str,
        jqxhr = $.ajax('https://www.puskesmas-sentolo2.com/getformresponse.php?id=' + formId)
            .done(function (response) {
                // if (response.ResponseMessage != "0") {
                //     alert(response.ResponseMessage);
                //     return;
                // }
                data = response.ResponseObject;

                // Iterate each column and print table headers for Datatables
                $.each(data.columns, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName + '>thead>tr');
                });

                // Add some Render transformations to Columns
                // Not a good practice to add any of this in API/ Json side
                data.columns[0].render = function (data, type, row) {
                    return '<h5><strong>' + data + '</strong></h5>';
                }
                // Debug? console.log(data.columns[0]);

                $(tableName).dataTable({
                    "data": data.data,
                    "columns": data.columns,
                    "dom":"Bfrtip",
                    "buttons": [
                        'copy', 'excel', 'pdf'
                    ],
                    "fnInitComplete": function () {
                        // Event handler to be fired when rendering is complete (Turn off Loading gif for example)
                        console.log('Datatable rendering complete');
                    }
                });
            })
            .fail(function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            });
}

class Form {
    construct() {
        this.id = null;
        this.name = null;
        this.date_created = null;
        this.created_by = null;
        this.description = null;
        this.questions = Array();
    }
}

class Question {
    construct() {
        this.id = null;
        this.question = null;
        this.number = null;
        this.required = false;
        this.input = Array();
    }
}

class Input {
    construct() {
        this.id = null;
        this.text = null;
        this.type = null;
    }
}

class InputType {
    static Text = "TEXT";
    static LongText = "LONG_TEXT";
    // static Select = "SELECT_OPTION";
    static Radiobutton = "RADIO";
    static Checkbox = "CHECK";
    static Dropdown = "DROPDOWN"
    static Date = "DATE";
}

class FormResponse{
    construct(){
        this.id = null;
        this.form_id = null;
        this.user_id = null;
        this.date_created = null;
        this.responses = Array();
    }
}

class Response{
    construct(){
        this.id = null;
        this.question_id = null;
        this.response_value = null;
    }
}

function submitFormResponse(form){
    var formResponseModel = new FormResponse();
    formResponseModel.id = form.id;
    formResponseModel.form_id = form.id;
    formResponseModel.responses = Array();
    $('input[type="text"]').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    $('input[type="radio"]:checked').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    $('input[type="checkbox"]:checked').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    $('input[type="date"]').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    $('textarea').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    $('option:selected').each(function(e){
        var response = new Response();
        response.question_id = $(this).attr("data-questionid");
        response.response_value = $(this).val();
        formResponseModel.responses.push(response);
    });
    console.log(formResponseModel);
    $.ajax({
        method: 'POST',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "https://www.puskesmas-sentolo2.com/formsubmitresponse.php",
        data: JSON.stringify(formResponseModel),
        success: function (data) {
            alert(data.ResponseMessage);
            if (data.ResponseCode == 0) {
                window.location = 'daftar-form.php';
            }
        },
        statusCode: {
            400: function () {
                alert('error');
            },
            500: function () {
                alert('server error');
            }
        }
    });
}