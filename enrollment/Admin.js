
const adminList = document.getElementById('admin-list');
const addAdminBtn = document.getElementById('add-admin-btn');
const deleteAdminBtn = document.getElementById('delete-admin-btn');
const addAdminModal = document.getElementById('add-admin-modal');
const deleteAdminModal = document.getElementById('delete-admin-modal');

fetch('/api/admins')
  .then(response => response.json())
  .then(admins => {
    admins.forEach(admin => {
      const listItem = document.createElement('li');
      listItem.textContent = `${admin.name} (${admin.email})`;
      adminList.appendChild(listItem);
    });
  });

addAdminBtn.addEventListener('click', () => {
  addAdminModal.style.display = 'block';
});

deleteAdminBtn.addEventListener('click', () => {
  deleteAdminModal.style.display = 'block';
});

// add event listener for add admin form submission
document.getElementById('add-admin-submit').addEventListener('click', () => {
  const newAdminName = document.getElementById('new-admin-name').value;
  const newAdminEmail = document.getElementById('new-admin-email').value;
  // send request to add new admin to database
  fetch('/api/add-admin', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name: newAdminName, email: newAdminEmail })
  })
    .then(response => response.json())
    .then(() => {
      // refresh admin list
      fetch('/api/admins')
        .then(response => response.json())
        .then(admins => {
          adminList.innerHTML = '';
          admins.forEach(admin => {
            const listItem = document.createElement('li');
            listItem.textContent = `${admin.name} (${admin.email})`;
            adminList.appendChild(listItem);
          });
        });
    });
});
document.getElementById('delete-admin-confirm').addEventListener('click', () => {
  const adminId = // get the ID of the admin to be deleted
  // send request to delete admin from database
  fetch(`/api/delete-admin/${adminId}`, {
    method: 'DELETE'
  })
    .then(response => response.json())
    .then(() => {
      // refresh admin list
      fetch('/api/admins')
        .then(response => response.json())
        .then(admins => {
          adminList.innerHTML = '';
          admins.forEach(admin => {
            const listItem = document.createElement('li');
            listItem.textContent = `${admin.name} (${admin.email})`;
            adminList.appendChild(listItem);
          });
        });
    });
});