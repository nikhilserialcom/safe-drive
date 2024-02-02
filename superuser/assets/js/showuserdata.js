var url = window.location.href;
var urlParams = new URLSearchParams(window.location.search);
var id = urlParams.get('id');
let vehicle_name = urlParams.get('vehicle_name');

const user_avatar_box = document.querySelector('.user_avatar');
const user_details = document.querySelector('.user_details');
const aadhar_card = document.querySelector('.aadhar_card');
const police_doc_data = document.querySelector('.police_data');
const insurance_doc_data = document.querySelector('.insurance_data');
const driving_licese = document.querySelector('.licese_data');
const vehicle_info = document.querySelector('.vehicle_info');
const popup_image = document.querySelector('.popup_image');
const close_popup_btn = document.querySelector('.close_popup');
const aadhar_msg_box = document.querySelector('.aadhar');
const license_msg_box = document.querySelector('.license');
const vehicale_msg_box = document.querySelector('.vehicale');
const insurance_msg_box = document.querySelector('.insurance');
const police_msg_box = document.querySelector('.police');
const active_btn = document.querySelector('.active_btn');

const action_btn = document.querySelector('.action-btn');
const insurance_btn = document.querySelector('.insurance_btn');
const aadhar_btn = document.querySelector('.aadhar_btn');
const licese_btn = document.querySelector('.licese_btn');
const police_btn = document.querySelector('.police_btn');
const vehicel_btn = document.querySelector('.vehicel_btn');
const driver_btn = document.querySelector('.driver_btn');
const driver_active_ms_box = document.querySelector('.driver_active');

const back_btn = document.querySelector('.back_btn');

const alldriverdata_url = 'api/alldriverdata.php';
const approved_url = 'api/approved.php';
const active_driver_url = 'api/activedriver.php';
const checkdocument_url = 'api/checkdocument.php';
var driverId;

const areAllDatabaseEmpty = (obj) => {
    for (const key in obj) {
        if (key !== "driver_status" && obj[key] !== "database empty") {
            return false;
        }
        return true;
    }
}

const checkdocument = (driver_Id, vehicle_name) => {
    fetch(checkdocument_url, {
        method: 'POST',
        body: JSON.stringify({
            driverId: driver_Id,
            vehicle_type: vehicle_name
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            const table_name = json.table;
            if (json.status == 200) {
                // console.log(table_name);
                const kit = areAllDatabaseEmpty(json.table);
                if (kit == true) {
                    driver_btn.classList.remove('action-btn');
                    driver_btn.classList.add('empty');
                    driver_active_ms_box.style.display = 'block';
                    driver_active_ms_box.innerHTML = `<span class="bg-label-warning">document not uploaded</span>`;
                }

                if (table_name.driver_status == "active") {
                    driver_btn.classList.remove('action-btn');
                    driver_btn.classList.add('empty');
                    driver_active_ms_box.style.display = 'block';
                    driver_active_ms_box.innerHTML = `<span class="alert-success">active</span>`;
                }
                else if (table_name.driver_status == "reject") {
                    driver_btn.classList.remove('action-btn');
                    driver_btn.classList.add('empty');
                    driver_active_ms_box.style.display = 'block';
                    driver_active_ms_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }

                if (table_name.adhaarcard == "approved") {
                    aadhar_btn.classList.remove('action-btn');
                    aadhar_btn.classList.add('empty');
                    aadhar_msg_box.style.display = 'block';
                    aadhar_msg_box.innerHTML = `<span class="alert-success">approved</span>`;
                }
                else if (table_name.adhaarcard == "rejected") {
                    aadhar_btn.classList.remove('action-btn');
                    aadhar_btn.classList.add('empty');
                    aadhar_msg_box.style.display = 'block';
                    aadhar_msg_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }

                if (table_name.driving_licese_info == "approved") {
                    licese_btn.classList.remove('action-btn');
                    licese_btn.classList.add('empty');
                    license_msg_box.style.display = 'block';
                    license_msg_box.innerHTML = `<span class="alert-success">approved</span>`;
                }
                else if (table_name.driving_licese_info == "rejected") {
                    licese_btn.classList.remove('action-btn');
                    licese_btn.classList.add('empty');
                    license_msg_box.style.display = 'block';
                    license_msg_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }

                if (table_name.vehicleinfo == "approved") {
                    vehicel_btn.classList.remove('action-btn');
                    vehicel_btn.classList.add('empty');
                    vehicale_msg_box.style.display = 'block';
                    vehicale_msg_box.innerHTML = `<span class="alert-success">approved</span>`;
                }
                else if (table_name.vehicleinfo == "rejected") {
                    vehicel_btn.classList.remove('action-btn');
                    vehicel_btn.classList.add('empty');
                    vehicale_msg_box.style.display = 'block';
                    vehicale_msg_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }

                if (table_name.police_clearance_certificate == "approved") {

                    police_btn.classList.remove('action-btn');
                    police_btn.classList.add('empty');
                    police_msg_box.style.display = 'block';
                    police_msg_box.innerHTML = `<span class="alert-success">approved</span>`;
                }
                else if (table_name.police_clearance_certificate == "rejected") {
                    police_btn.classList.remove('action-btn');
                    police_btn.classList.add('empty');
                    police_msg_box.style.display = 'block';
                    police_msg_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }

                if (table_name.vehicle_insurance == "approved") {
                    insurance_btn.classList.remove('action-btn');
                    insurance_btn.classList.add('empty');
                    insurance_msg_box.style.display = 'block';
                    insurance_msg_box.innerHTML = `<span class="alert-success">approved</span>`;
                }
                else if (table_name.vehicle_insurance == "rejected") {
                    insurance_btn.classList.remove('action-btn');
                    insurance_btn.classList.add('empty');
                    insurance_msg_box.style.display = 'block';
                    insurance_msg_box.innerHTML = `<span class="alert-danger">rejected</span>`;
                }
            }
        })
}

checkdocument(id, vehicle_name);

const driverData = (id, vehicle_name) => {
    fetch(alldriverdata_url, {
        method: 'POST',
        body: JSON.stringify({
            userId: id,
            vehicle_type: vehicle_name
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            const driver_data = json.driverData;
            const aadhar_data = json.aadharData;
            const police_data = json.policeData;
            const insurance_data = json.insuranceData;
            const licese_data = json.liceseData;
            const vehicle_data = json.vehicleData;
            driverId = driver_data.driverId;
            const profile = driver_data.photo ? `<img src="../${driver_data.photo}" alt="" />` : '<img src="assets/img/user.png" alt="" />';
            const status = (driver_data.active_status == 'active') ? "active" : "unactive";
            if (json.status_code == 200) {
                user_avatar_box.innerHTML = `
                <div class="user_profile">
                    ${profile}
                </div>
                <div class="user_info">
                    <p class="user_name">${driver_data.firstname} ${driver_data.lastname}</p>
                    <p class="user_type bg-label-secondary">driver</p>
                </div>
                `;

                user_details.innerHTML = `
                <ul>
                    <li>
                        <span>mobile number:</span>
                        <span>${driver_data.mobile_number}</span>
                    </li>
                    <li>
                        <span>email:</span>
                        <span>${driver_data.email}</span>
                    </li>
                    <li>
                        <span>date of birth:</span>
                        <span>${driver_data.dob}</span>
                    </li>
                    <li>
                        <span>city:</span>
                        <span>${driver_data.city}</span>
                    </li>
                    <li>
                        <span>status:</span>
                        <span class="badge bg-label-success">${status}</span>
                    </li>
                    <li>
                        <span>vehicle type:</span>
                        <span>${driver_data.vehicleType}</span>
                    </li>
                </ul>
                `;
                // <li>
                //     <span>vehicle brand:</span>
                //     <span>${driver_data.vehicleBrand}</span>
                // </li>

                if (aadhar_data == '') {
                    aadhar_card.innerHTML = `
                    <div class="empty_msg">
                        <p>no recore found</p>
                    </div>`;
                    aadhar_btn.classList.remove('action-btn');
                    aadhar_btn.classList.add('empty');
                }
                else {
                    const aadhar_fornt = aadhar_data.front_photo_adhaar ? `<img src="../driver/${aadhar_data.front_photo_adhaar}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`;
                    const aadhar_back = aadhar_data.back_photo_adhaar ? `<img src="../driver/${aadhar_data.back_photo_adhaar}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`;
                    const aadhar_selfy = aadhar_data.selfi_with_adhaar ? `<img src="../driver/${aadhar_data.selfi_with_adhaar}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`;

                    aadhar_card.innerHTML = `
                        <div class="info_header">
                            <span>aadhar no:</span>
                            <span>${aadhar_data.adhaar_no}</span>
                        </div>
                        <div class="info_document">
                            <div class="document_img_box">
                                ${aadhar_fornt}
                            </div>
                            <div class="document_img_box">
                                ${aadhar_back}
                            </div>
                            <div class="document_img_box">
                               ${aadhar_selfy}
                            </div>
                        </div>
                    `;
                }

                if (licese_data == '') {
                    driving_licese.innerHTML = `
                    <div class="empty_msg">
                        <p>no recore found</p>
                    </div>`;
                    licese_btn.classList.remove('action-btn');
                    licese_btn.classList.add('empty');
                }
                else {
                    const licence_front = licese_data.front_photo_DL ? `<img src="../driver/${licese_data.front_photo_DL}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const licence_back = licese_data.back_photo_DL ? `<img src="../driver/${licese_data.back_photo_DL}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const licence_selfy = licese_data.selfi_with_DL ? `<img src="../driver/${licese_data.selfi_with_DL}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`

                    driving_licese.innerHTML = `
                        <div class="info_header">
                            <ul>
                                <li>
                                    <span>driveing licence no:</span>
                                    <span>${licese_data.driving_licese_no}</span>
                                </li>
                                <li>
                                    <span>expiration date:</span>
                                    <span>${licese_data.expiration_date}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="info_document">
                            <div class="document_img_box">
                                ${licence_front}
                            </div>
                            <div class="document_img_box">
                               ${licence_back}
                            </div>
                            <div class="document_img_box">
                                ${licence_selfy}
                            </div>
                        </div>
                    `;
                }


                if (police_data == '') {
                    police_doc_data.innerHTML = `
                    <div class="empty_msg">
                        <p>no recore found</p>
                    </div>`;
                    police_btn.classList.remove('action-btn');
                    police_btn.classList.add('empty');
                }
                else {
                    const police_doc = police_data.Police_clearance_certificate ? `<img src="../driver/${police_data.Police_clearance_certificate}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`;

                    police_doc_data.innerHTML = `
                        <div class="info_document">
                            <div class="document_img_box">
                                ${police_doc}
                            </div>
                        </div>
                    `;
                }


                if (insurance_data == '') {
                    insurance_doc_data.innerHTML = `
                    <div class="empty_msg">
                        <p>no recore found</p>
                    </div>`;
                    insurance_btn.classList.remove('action-btn');
                    insurance_btn.classList.add('empty');
                }
                else {
                    insurance_btn.classList.remove('empty');
                    const insurance_doc = insurance_data.vehicle_insurance ? `<img src="../driver/${insurance_data.vehicle_insurance}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`;

                    insurance_doc_data.innerHTML = `
                    <div class="info_document">
                        <div class="document_img_box">
                            ${insurance_doc}
                        </div>
                    </div>
                `;
                }

                if (vehicle_data == '') {
                    vehicle_info.innerHTML = `
                    <div class="empty_msg">
                        <p>no recore found</p>
                    </div>`;
                    vehicel_btn.classList.remove('action-btn');
                    vehicel_btn.classList.add('empty');
                }
                else {
                    const car_front = vehicle_data.car_photo ? `<img src="../driver/${vehicle_data.car_photo}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const car_back = vehicle_data.backside_photo ? `<img src="../driver/${vehicle_data.backside_photo}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const car_right = vehicle_data.rigthside_photo ? `<img src="../driver/${vehicle_data.rigthside_photo}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const car_left = vehicle_data.leftside_photo ? `<img src="../driver/${vehicle_data.leftside_photo}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const rc_front = vehicle_data.frontRC ? `<img src="../driver/${vehicle_data.frontRC}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const rc_back = vehicle_data.backRC ? `<img src="../driver/${vehicle_data.backRC}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const rc_selfy = vehicle_data.selfiwithRC ? `<img src="../driver/${vehicle_data.selfiwithRC}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const front_parmit = vehicle_data.frontParmit ? `<img src="../driver/${vehicle_data.frontParmit}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`
                    const back_parmit = vehicle_data.backParmit ? `<img src="../driver/${vehicle_data.backParmit}" alt="">` : `<img src="assets/img/aadharcard1.png" alt="">`

                    vehicle_info.innerHTML = `
                        <div class="info_header">
                            <ul>
                                <li>
                                    <span>vahicle Brand:</span>
                                    <span>${vehicle_data.vehicle_type}</span>
                                </li>
                                <li>
                                    <span>vahicle Brand:</span>
                                    <span>${vehicle_data.vehicle_brand_name}</span>
                                </li>
                                <li>
                                    <span>vahicel modal:</span>
                                    <span>${vehicle_data.modal}</span>
                                </li>
                                <li>
                                    <span>number plate no:</span>
                                    <span>${vehicle_data.Number_plate}</span>
                                </li>
                                <li>
                                    <span>transport year:</span>
                                    <span>${vehicle_data.transport_year}</span>
                                </li>
                            </ul>
                        </div>
                        <h4>vehicel document:</h4>
                        <div class="vehicel_car_document">
                            <div class="car_img_box">
                                ${car_front}
                            </div>
                            <div class="car_img_box">
                                ${car_back}
                            </div>
                            <div class="car_img_box">
                                ${car_right}
                            </div>
                            <div class="car_img_box">
                               ${car_left}
                            </div>
                        </div>
                        <h4>rc document:</h4>
                        <div class="info_document">
                            <div class="document_img_box">
                                ${rc_front}
                            </div>
                            <div class="document_img_box">
                                ${rc_back}
                            </div>
                            <div class="document_img_box">
                                ${rc_selfy}
                            </div>
                        </div>
                        <h4>parmit document:</h4>
                        <div class="info_document">
                            <div class="document_img_box">
                                ${front_parmit}
                            </div>
                            <div class="document_img_box">
                                ${back_parmit}
                            </div>
                        </div>
                    `;
                }

            }
            else {
                window.location.href = 'index.php';
            }

            const info_document_div = document.querySelectorAll('.info_document .document_img_box');
            const vehicel_car_document_div = document.querySelectorAll('.vehicel_car_document .car_img_box');

            info_document_div.forEach(element => {
                element.addEventListener('click', () => {
                    const image = element.querySelector('img');
                    console.log(image.src);
                    popup_image.style.display = 'block';
                    popup_image.querySelector('img').src = image.src;
                })
            })

            vehicel_car_document_div.forEach(element => {
                element.onclick = () => {
                    const image = element.querySelector('img');
                    console.log(image.src);
                    popup_image.style.display = 'block';
                    popup_image.querySelector('img').src = image.src;
                }
            })
        })
}

driverData(id, vehicle_name);

close_popup_btn.addEventListener('click', () => {
    popup_image.style.display = 'none';
})
const approvedData = (driver_Id, vehicleType, action_type, reason, doc_type) => {
    fetch(approved_url, {
        method: 'POST',
        body: JSON.stringify({
            driverId: driver_Id,
            vehicle_type: vehicleType,
            rejectedReason: reason,
            status: action_type,
            docType: doc_type
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.status_code == 200) {
                var alert_msg = json.message;
                const alert_class = (json.message == 'approved') ? 'alert-success' : 'alert-danger';
                reject_input.value = '';
                if (json.doc_name == 'aadhar') {
                    aadhar_reject_btn.parentElement.classList.add('d_none');
                    aadhar_msg_box.style.display = 'block';
                    aadhar_msg_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
                }
                else if (json.doc_name == 'license') {
                    license_reject_btn.parentElement.classList.add('d_none');
                    license_msg_box.style.display = 'block';
                    license_msg_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
                }
                else if (json.doc_name == 'police') {
                    police_reject_btn.parentElement.classList.add('d_none');
                    police_msg_box.style.display = 'block';
                    police_msg_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
                }
                else if (json.doc_name == 'insurance') {
                    insurance_reject_btn.parentElement.classList.add('d_none');
                    insurance_msg_box.style.display = 'block';
                    insurance_msg_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
                }
                else if (json.doc_name == 'vehicale') {
                    vehicel_reject_btn.parentElement.classList.add('d_none');
                    vehicale_msg_box.style.display = 'block';
                    vehicale_msg_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
                }

            }
        })
}



const aadhar_approve_btn = document.querySelector('.aadhar_approve_btn');
const aadhar_reject_btn = document.querySelector('.aadhar_reject_btn');
const license_approve_btn = document.querySelector('.license_approve_btn');
const license_reject_btn = document.querySelector('.license_reject_btn');
const police_approve_btn = document.querySelector('.police_approve_btn');
const police_reject_btn = document.querySelector('.police_reject_btn');
const insurance_approve_btn = document.querySelector('.insurance_approve_btn');
const insurance_reject_btn = document.querySelector('.insurance_reject_btn');
const vehicel_approve_btn = document.querySelector('.vehicel_approve_btn');
const vehicel_reject_btn = document.querySelector('.vehicel_reject_btn');

let document_name, reason;
const done_btn = document.querySelector('.done_btn');
const reject_modal = document.querySelector('.reject_modal');
const reject_input = document.querySelector('.reject_input');

aadhar_approve_btn.addEventListener('click', () => {
    reason = "";
    approvedData(driverId, vehicle_name, 'accept', reason, 'aadhar');
    aadhar_approve_btn.parentElement.classList.add('d_none');
})

license_approve_btn.addEventListener('click', () => {
    reason = "";
    approvedData(driverId, vehicle_name, 'accept', reason, 'license');
    license_approve_btn.parentElement.classList.add('d_none');
})

police_approve_btn.addEventListener('click', () => {
    reason = "";
    approvedData(driverId, vehicle_name, 'accept', reason, 'police');
    police_approve_btn.parentElement.classList.add('d_none');
})

insurance_approve_btn.addEventListener('click', () => {
    reason = "";
    approvedData(driverId, vehicle_name, 'accept', reason, 'insurance');
    insurance_approve_btn.parentElement.classList.add('d_none');
})

vehicel_approve_btn.addEventListener('click', () => {
    reason = "";
    approvedData(driverId, vehicle_name, 'accept', reason, 'vehical');
    vehicel_approve_btn.parentElement.classList.add('d_none');
})

aadhar_reject_btn.addEventListener('click', () => {
    document_name = 'aadhar'
    reject_modal.style.display = 'block';
})

license_reject_btn.addEventListener('click', () => {
    document_name = 'license';
    reject_modal.style.display = 'block';
})

police_reject_btn.addEventListener('click', () => {
    document_name = 'police';
    reject_modal.style.display = 'block';
})

insurance_reject_btn.addEventListener('click', () => {
    document_name = 'insurance';
    reject_modal.style.display = 'block';
})
vehicel_reject_btn.addEventListener('click', () => {
    document_name = 'vehilce';
    reject_modal.style.display = 'block';
})

done_btn.addEventListener('click', () => {
    approvedData(driverId, vehicle_name, 'reject', reject_input.value, document_name);
    reject_modal.style.display = 'none';
})

const active_driver_btn = document.querySelector('.active_driver');
const reject_driver_btn = document.querySelector('.reject_driver');

const close_btn = document.querySelector('.close');

const doc_list = document.querySelectorAll('.docu_list input');

const activeDriver = (driver_Id, driver_status) => {
    fetch(active_driver_url, {
        method: 'POST',
        body: JSON.stringify({
            driverId: driver_Id,
            driverStatus: driver_status,
        }),
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => response.json())
        .then(json => {
            console.log(json);
            if (json.status_code == 200) {
                reject_modal.style.display = 'none';
                const alert_msg = (json.message == "active") ? "active" : "reject";
                const alert_class = (json.message == "active") ? "alert-success" : "alert-danger";
                driver_btn.classList.remove('action-btn');
                driver_btn.classList.add('empty');
                driver_active_ms_box.style.display = 'block';
                driver_active_ms_box.innerHTML = `<span class="${alert_class}">${alert_msg}</span>`;
            }
            else {
                console.log(json.message);
            }
        })
}

var document_list = [];

doc_list.forEach(element => {
    element.addEventListener('change', () => {
        if (element.checked) {
            document_list.push(element.value);
        }
        else {
            const index = document_list.indexOf(element.value);
            if (index !== -1) {
                document_list.splice(index, 1);
            }
        }
    })
})


active_driver_btn.addEventListener('click', () => {
    let driver_status = "active";
    activeDriver(id, driver_status);
})

reject_driver_btn.addEventListener('click', () => {
    let driver_status = "reject";
    activeDriver(id, driver_status);
})

close_btn.addEventListener('click', () => {
    reject_modal.style.display = 'none';
})

back_btn.addEventListener('click', () => {
    window.location.href = 'users.php';
})

window.addEventListener('click', (event) => {
    // console.log(event.target);
    if (event.target == reject_modal) {
        reject_modal.style.display = "none";
        reject_input.value = '';
    }
});