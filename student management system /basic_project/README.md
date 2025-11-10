# Student Management System

A simple Node.js + Express app that manages students stored in a JSON file. The frontend is a static site served from the `public/` directory.

## Structure

```
basic_project/
├── server.js              # Express server + REST API
├── students.json          # Data file (auto-created on first POST)
├── public/
│   ├── index.html         # UI
│   ├── style.css          # Styles
│   └── script.js          # Frontend logic
└── README.md
```

## API
- `GET /students` — list all students
- `POST /students` — add a student `{ name, marks }`
- `DELETE /students/:id` — delete a student by id

## Run locally (macOS / zsh)
```sh
cd "/Users/daiyaan/Desktop/HP Desktop /J-1/student management system /basic_project"
npm init -y
npm i express body-parser cors
node server.js
```
Open http://localhost:3000 in your browser.
