const user_list_box = document.querySelector('.order .user_list');
const recent_user_url = 'api/recentuser.php';
// console.log(user_list_box);
const recent_user = () => {
  fetch(recent_user_url, {
    method: 'GET',
    headers: {
      'Content-type': 'application/json; charset=UTF-8',
    },
  })
    .then(response => response.json())
    .then(json => {
      console.log(json);
      let userData = json.userList;
      if (json.status_code == 200) {
        user_list_box.innerHTML = userData.map(val => {
          const { firstname,created_at,driverstatus,photo } = val;
          const parseDate = new Date(created_at);
                const formattedDate = new Intl.DateTimeFormat('en-US', {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                }).format(parseDate);
          const profile = photo ? `<img src="../${photo}" alt="" />` : '<img src="assets/img/profile.png" alt="" />';
          let status = (driverstatus == "online") ? "active" : "pending";
          let status_class = (driverstatus == "online") ? "bg-label-success" : "bg-label-warning";
          return `
            <tr>
                <td>
                    <div class="plus_icon">
                        <i class='bx bxs-plus-circle'></i>
                    </div>
                </td>
                <td>
                   ${profile}
                    <p>${firstname}</p>
                </td>
                <td>${formattedDate}</td>
                <td><span class="status ${status_class}">${status}</span></td>
            </tr>`;
        }).join('');
        
      }
      else {
        console.log(json.message);
      }
    })
}

recent_user();