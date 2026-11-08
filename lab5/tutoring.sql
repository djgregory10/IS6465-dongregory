-- Lab 5: Build and Query the Peer Tutoring Hub Database
-- Run on a fresh database:  rm -f tutoring.db && sqlite3 tutoring.db < tutoring.sql

.headers on
.mode column

PRAGMA foreign_keys = ON;

-- =====================================================
-- Part 1: Create tables
-- =====================================================
CREATE TABLE IF NOT EXISTS students (
  student_id    INTEGER PRIMARY KEY,
  student_name  TEXT NOT NULL,
  student_email TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tutoring_requests (
  request_id     INTEGER PRIMARY KEY,
  student_id     INTEGER NOT NULL,
  course         TEXT NOT NULL,
  topic          TEXT NOT NULL,
  preferred_date TEXT NOT NULL,
  preferred_time TEXT NOT NULL,
  status         TEXT NOT NULL DEFAULT 'Open',
  created_at     TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(student_id)
);

.print '--- Part 1: .tables ---'
.tables
.print '--- Part 1: .schema ---'
.schema

-- =====================================================
-- Part 2: Insert students and tutoring requests
-- =====================================================
-- Each student is inserted exactly once.
INSERT INTO students (student_name, student_email)
VALUES ('Jordan Lee', 'jordan.lee@example.edu');   -- student_id 1

INSERT INTO students (student_name, student_email)
VALUES ('Avery Patel', 'avery.patel@example.edu'); -- student_id 2

-- Jordan's two requests (student_id = 1)
INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'Forms', '2026-11-12', '14:00');

INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'SQL SELECT', '2026-11-13', '15:30');

-- Avery's request (student_id = 2)
INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (2, 'IS 6465', 'SQLite CRUD', '2026-11-16', '10:00');

.print '--- Part 2: SELECT * FROM students ---'
SELECT * FROM students;
.print '--- Part 2: SELECT * FROM tutoring_requests ---'
SELECT * FROM tutoring_requests;

-- =====================================================
-- Part 3: Read the stored data
-- =====================================================
.print '--- Part 3.1: all students ---'
SELECT * FROM students;

.print '--- Part 3.2: all tutoring requests ---'
SELECT * FROM tutoring_requests;

.print '--- Part 3.3: only Open requests ---'
SELECT * FROM tutoring_requests WHERE status = 'Open';

.print '--- Part 3.4: one request by request_id ---'
SELECT * FROM tutoring_requests WHERE request_id = 2;

.print '--- Part 3.5: request list with JOIN, ordered by preferred_date ---'
SELECT
  r.request_id,
  s.student_name,
  s.student_email,
  r.course,
  r.topic,
  r.preferred_date,
  r.preferred_time,
  r.status
FROM tutoring_requests AS r
JOIN students AS s ON r.student_id = s.student_id
ORDER BY r.preferred_date;

-- =====================================================
-- Part 4: Update one request
-- =====================================================
.print '--- Part 4: BEFORE update (request 2) ---'
SELECT request_id, topic, preferred_date, preferred_time, status
FROM tutoring_requests WHERE request_id = 2;

-- Revise one of Jordan's open requests (only request_id 2 changes)
UPDATE tutoring_requests
SET topic = 'SQL SELECT and JOIN',
    preferred_date = '2026-11-14',
    preferred_time = '16:00'
WHERE request_id = 2;

.print '--- Part 4: AFTER update (request 2) ---'
SELECT request_id, topic, preferred_date, preferred_time, status
FROM tutoring_requests WHERE request_id = 2;

-- Cancel Avery's request (request_id 3)
UPDATE tutoring_requests
SET status = 'Cancelled'
WHERE request_id = 3;

.print '--- Part 4: Avery - Cancelled status ---'
SELECT r.request_id, s.student_name, r.topic, r.status
FROM tutoring_requests AS r
JOIN students AS s ON r.student_id = s.student_id
WHERE r.request_id = 3;

-- =====================================================
-- Part 5: Delete one test request
-- =====================================================
INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'Delete Practice', '2026-11-20', '09:00');  -- request_id 4

.print '--- Part 5: BEFORE delete ---'
SELECT request_id, student_id, topic, status FROM tutoring_requests;

DELETE FROM tutoring_requests
WHERE request_id = 4;

.print '--- Part 5: AFTER delete (test record gone, others remain) ---'
SELECT request_id, student_id, topic, status FROM tutoring_requests;

-- =====================================================
-- Part 6: CRUD summary (final state)
-- =====================================================
.print '--- Part 6: final JOIN view ---'
SELECT
  r.request_id,
  s.student_name,
  s.student_email,
  r.course,
  r.topic,
  r.preferred_date,
  r.preferred_time,
  r.status
FROM tutoring_requests AS r
JOIN students AS s ON r.student_id = s.student_id
ORDER BY r.preferred_date;

