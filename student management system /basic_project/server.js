const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const cors = require('cors');
const path = require('path');

const app = express();
const DATA_FILE = path.join(__dirname, 'students.json');

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));

// Helpers
function readStudents() {
  if (!fs.existsSync(DATA_FILE)) return [];
  const data = fs.readFileSync(DATA_FILE, 'utf8');
  try {
    return JSON.parse(data || '[]');
  } catch (e) {
    return [];
  }
}
function writeStudents(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));
}

// Routes
app.get('/students', (req, res) => {
  const students = readStudents();
  res.json(students);
});

app.post('/students', (req, res) => {
  const { name, marks } = req.body;
  if (!name || Number.isNaN(Number(marks))) {
    return res.status(400).json({ error: 'Invalid name or marks' });
  }
  const students = readStudents();
  const newStudent = {
    id: Date.now(),
    name: String(name).trim(),
    marks: Number(marks)
  };
  students.push(newStudent);
  writeStudents(students);
  res.json(newStudent);
});

app.delete('/students/:id', (req, res) => {
  const id = parseInt(req.params.id, 10);
  let students = readStudents();
  const before = students.length;
  students = students.filter(s => s.id !== id);
  writeStudents(students);
  res.json({ message: 'Deleted successfully', removed: before - students.length });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`🚀 Server running at http://localhost:${PORT}`));
