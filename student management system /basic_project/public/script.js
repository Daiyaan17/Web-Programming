const form = document.getElementById('studentForm');
const tableBody = document.getElementById('studentTable');
const searchInput = document.getElementById('searchName');
const searchBtn = document.getElementById('searchBtn');
const searchResult = document.getElementById('searchResult');

async function loadStudents() {
  const res = await fetch('/students');
  const students = await res.json();
  tableBody.innerHTML = '';
  students.forEach(s => {
    const row = `<tr>
      <td>${s.id}</td>
      <td>${s.name}</td>
      <td>${s.marks}</td>
      <td><button onclick="deleteStudent(${s.id})">Delete</button></td>
    </tr>`;
    tableBody.innerHTML += row;
  });
}

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const name = document.getElementById('name').value.trim();
  const marks = document.getElementById('marks').value;
  if (!name) return;
  await fetch('/students', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name, marks })
  });
  form.reset();
  loadStudents();
});

async function deleteStudent(id) {
  await fetch(`/students/${id}`, { method: 'DELETE' });
  loadStudents();
}

searchBtn.addEventListener('click', async () => {
  const name = searchInput.value.trim().toLowerCase();
  if (!name) {
    searchResult.textContent = 'Please enter a student name.';
    return;
  }
  const res = await fetch('/students');
  const students = await res.json();
  const found = students.find(s => s.name.toLowerCase() === name);
  if (found) {
    searchResult.textContent = `${found.name}'s marks: ${found.marks}`;
  } else {
    searchResult.textContent = 'Student not found.';
  }
});

window.addEventListener('DOMContentLoaded', loadStudents);
