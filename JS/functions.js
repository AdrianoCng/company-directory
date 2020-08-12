const getRequestAllPersonnel = (index) => {

    $.get(`./PHP/getAllPersonnel.php?page=${index}`, (data) => {
        renderCards(data);
    });

};

const getRequestPersonnelByLocation = (data, page) => {

    const string = data + "&page=" + page;

    $.post(`./PHP/getPersonnelByOptions.php`, string, (data) => {

        renderCards(data);

    });

};

const searchByName = (data, index) => {

    const string = data + "&page=" + index;

    $.post(`./PHP/searchByName.php`, string, (data) => {

        renderCards(data);

    });

};

const renderCards = data => {

    $(".card-deck").html("");
    $("#modalDiv").html("");
    
    for (let index = 0; index < data.data.length; index++) {

        const random = Math.floor(Math.random() * 70);

        /* FOR A BLANK PROFILE PICTURE CHANGE SRC ATTRIBUTE DIV.AVATAR IMG */
        /* https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png */

        const card = `
            <div class="card hovercard">
                <div class="cardheader" style="background: url('https://picsum.photos/850/280?random=${random}')" role="button" data-toggle="modal" data-target="#modal-${data.data[index].id}"></div>
                <div class="avatar" role="button" data-toggle="modal" data-target="#modal-${data.data[index].id}">
                    <img alt="" src="https://i.pravatar.cc/150?img=${random}">
                </div>
                <div class="info">
                    <div class="title">
                        <a href="#" data-toggle="modal" data-target="#modal-${data.data[index].id}">${data.data[index].firstName} ${data.data[index].lastName}</a>
                    </div>
                    <div class="desc">${data.data[index].departmentName}</div>
                    <div class="desc">${data.data[index].locationName}</div>
                    <div class="desc"><a href="#">${data.data[index].email}</a></div>
                </div>
                <div class="bottom">
                    <a class="btn btn-primary btn-twitter btn-sm" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-danger btn-sm" rel="publisher" href="#"><i class="fab fa-google"></i></a>
                    <a class="btn btn-primary btn-sm" rel="publisher" href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>`;

        const modal = `
            <div class="modal fade" id="modal-${data.data[index].id}" tabindex="-1" role="dialog" aria-labelledby="update-deleteTitle${index}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update-deleteTitle${index}">${data.data[index].firstName} ${data.data[index].lastName}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mb-3">
                            <form action="" id="update-form-modal-${data.data[index].id}" method="POST">
                            <div id="alert-${data.data[index].id}"></div>
                            <div class="form-row">
                                <div class="col">
                                <label class="col-form-label" for="fname-update-delete${index}">First Name: </label>
                                <input class="form-control form-control-sm" type="text" name="fname" value="${data.data[index].firstName}" id="fname-update-delete${index}" required>
                                </div>
                                <div class="col">
                                <label class="col-form-label" for="lname-update-delete${index}">Last Name: </label>
                                <input class="form-control form-control-sm" type="text" name="lname" value="${data.data[index].lastName}" id="lname-update-delete${index}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                <label class="col-form-label" for="email-modal-update-delete${index}">Email: </label>
                                <input class="form-control form-control-sm" type="email" name="email" value="${data.data[index].email}" id="email-modal-update-delete${index}" required>
                                </div>                
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                <label class="col-form-label" for=department-modal-update-delete${data.data[index].id}">Department: </label>
                                <select class="custom-select custom-select-sm" name="department" id="department-modal-update-delete${data.data[index].id}" required>
                                    <option value="1">Human Resources</option>
                                    <option value="2">Sales</option>
                                    <option value="3">Marketing</option>
                                    <option value="4">Legal</option>
                                    <option value="5">Services</option>
                                    <option value="6">Research and Development</option>
                                    <option value="7">Product Management</option>
                                    <option value="8">Training</option>
                                    <option value="9">Support</option>
                                    <option value="10">Engineering</option>
                                    <option value="11">Accounting</option>
                                    <option value="12">Business Development</option>
                                </select>
                                </div>
                                <div class="col-6">
                                <label class="col-form-label" for="location-modal-update-delete${index}">Location: </label>
                                <input readonly class="form-control-sm form-control-plaintext" type="text" name="location" id="location-modal-update-delete${data.data[index].id}" value="${data.data[index].locationName}" required>
                                </div>                   
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                <input class="form-control form-control-sm" type="hidden" name="id" value="${data.data[index].id}" required>
                                </div>                
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                <input class="form-control form-control-sm" type="hidden" name="departmentId" value="${data.data[index].departmentId}" required>
                                </div>                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success float-left" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button type="submit" name="action" value="update" class="btn btn-success" id="update-${data.data[index].id}">Update</button>
                                <button type="submit" name="action" value="delete" class="btn btn-danger" id="delete-${data.data[index].id}">Delete</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`;
        
        $(".card-deck").append(card);
        $("#modalDiv").append(modal);


        $(`#department-modal-update-delete${index}`).on('change', function (e) {

            const valueSelected = this.value;
            
            switch (valueSelected) {
                case "1":
                case "4":
                case "5":
                    $(`#location-modal-update-delete${index}`).val("London");
                    break;
                case "2":
                case "3":
                    $(`#location-modal-update-delete${index}`).val("New York");
                    break;
                case "6":
                case "7":
                case "12":
                    $(`#location-modal-update-delete${index}`).val("Paris");
                    break;
                case "8":
                case "9":
                    $(`#location-modal-update-delete${index}`).val("Munich");
                    break;
                case "10":
                case "11":
                    $(`#location-modal-update-delete${index}`).val("Rome");
                    break;
            };

        });
    };
};

const loadPage = () => {

    $("#searchInput").val("");

    $.get("./PHP/getAllPersonnel.php", (data) => {

        $("ul.pagination").html("");

        for (let index = 1; index <= data.metadata.pages; index++) {

            if (index == 1) {

                const li = `<li class="page-item active mb-2"><a class="page-link" href="javascript:getRequestAllPersonnel('${index}')">${index}</a></li>`;
                $("ul.pagination").append(li);
                continue;

            }

             const li = `<li class="page-item mb-2"><a class="page-link" href="javascript:getRequestAllPersonnel('${index}')">${index}</a></li>`;
             $("ul.pagination").append(li);

        }

        renderCards(data);

    });

};