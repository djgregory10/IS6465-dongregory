# Lab 5 Notes: Peer Tutoring Hub Database

All SQL for this lab is in `tutoring.sql`. I ran it in SQLite with `sqlite3 tutoring.db < tutoring.sql`, and the output below is from that run.

## Part 1: Create the database tables

**Output of `.tables` and `.schema`:**

```text
students           tutoring_requests

CREATE TABLE students (
  student_id    INTEGER PRIMARY KEY,
  student_name  TEXT NOT NULL,
  student_email TEXT NOT NULL UNIQUE
);
CREATE TABLE tutoring_requests (
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
```

**Which column is the primary key in each table?**
In `students`, the primary key is `student_id`. In `tutoring_requests`, the primary key is `request_id`. Each one uniquely identifies a single row in its table.

**Which column is the foreign key, and what relationship does it represent?**
The foreign key is `tutoring_requests.student_id`, which references `students(student_id)`. It represents a one-to-many relationship: one student can submit many tutoring requests, but each request belongs to exactly one student.

**Why is `student_email` marked `UNIQUE`?**
Marking `student_email` as `UNIQUE` stops two student rows from sharing the same email address. Email identifies a person, so the database rejects duplicates and keeps one student from being stored twice.

## Part 2: Insert students and tutoring requests

**INSERT statements used:**

```sql
INSERT INTO students (student_name, student_email)
VALUES ('Jordan Lee', 'jordan.lee@example.edu');   -- student_id 1

INSERT INTO students (student_name, student_email)
VALUES ('Avery Patel', 'avery.patel@example.edu'); -- student_id 2

INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'Forms', '2026-11-12', '14:00');

INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'SQL SELECT', '2026-11-13', '15:30');

INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (2, 'IS 6465', 'SQLite CRUD', '2026-11-16', '10:00');
```

**Output of `SELECT *` on both tables:**

```text
student_id  student_name  student_email
----------  ------------  -----------------------
1           Jordan Lee    jordan.lee@example.edu
2           Avery Patel   avery.patel@example.edu

request_id  student_id  course   topic        preferred_date  preferred_time  status  created_at
----------  ----------  -------  -----------  --------------  --------------  ------  -------------------
1           1           IS 6465  Forms        2026-11-12      14:00           Open    2026-11-08 14:05:31
2           1           IS 6465  SQL SELECT   2026-11-13      15:30           Open    2026-11-08 14:05:31
3           2           IS 6465  SQLite CRUD  2026-11-16      10:00           Open    2026-11-08 14:05:31
```

**Why does Jordan have one student row but two request rows?**
Jordan is one person, so Jordan is stored once in `students` with `student_id` 1. Jordan made two separate tutoring requests (Forms and SQL SELECT), so there are two rows in `tutoring_requests`, and both store `student_id = 1`. Repeating the student row would duplicate Jordan's name and email, and the `UNIQUE` constraint on `student_email` would reject it anyway.

## Part 3: Read the stored data

Queries 1 to 4:

```sql
SELECT * FROM students;                                   -- 1. all students (2 rows)
SELECT * FROM tutoring_requests;                          -- 2. all requests (3 rows)
SELECT * FROM tutoring_requests WHERE status = 'Open';    -- 3. Open requests (3 rows at that point)
SELECT * FROM tutoring_requests WHERE request_id = 2;     -- 4. one request (returns only request 2)
```

Output for query 4:

```text
request_id  student_id  course   topic       preferred_date  preferred_time  status  created_at
----------  ----------  -------  ----------  --------------  --------------  ------  -------------------
2           1           IS 6465  SQL SELECT  2026-11-13      15:30           Open    2026-11-08 14:05:31
```

**JOIN query (query 5) and its output:**

```sql
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
```

```text
request_id  student_name  student_email            course   topic        preferred_date  preferred_time  status
----------  ------------  -----------------------  -------  -----------  --------------  --------------  ------
1           Jordan Lee    jordan.lee@example.edu   IS 6465  Forms        2026-11-12      14:00           Open
2           Jordan Lee    jordan.lee@example.edu   IS 6465  SQL SELECT   2026-11-13      15:30           Open
3           Avery Patel   avery.patel@example.edu  IS 6465  SQLite CRUD  2026-11-16      10:00           Open
```

**What does the JOIN condition connect?**
The condition `r.student_id = s.student_id` connects each tutoring request to the student who submitted it, by matching the foreign key in `tutoring_requests` to the primary key in `students`.

**What is the difference between the purpose of JOIN and WHERE?**
`JOIN` combines rows from two tables into one result by matching related columns, so I can show the student's name and email next to the request details. `WHERE` filters rows, keeping only the ones that meet a condition (such as `status = 'Open'` or `request_id = 2`). JOIN decides how tables are linked; WHERE decides which rows are kept.

**Why should the application retrieve one request by `request_id` instead of by topic alone?**
`request_id` is the primary key, so it is unique and returns exactly one request. A topic is not unique: Jordan and other students could submit requests with the same topic, so searching by topic could return several rows or the wrong one.

## Part 4: Update one request

**The two UPDATE statements:**

```sql
-- Revise one of Jordan's open requests
UPDATE tutoring_requests
SET topic = 'SQL SELECT and JOIN',
    preferred_date = '2026-11-14',
    preferred_time = '16:00'
WHERE request_id = 2;

-- Cancel Avery's request
UPDATE tutoring_requests
SET status = 'Cancelled'
WHERE request_id = 3;
```

**Before and after for the revised request (request 2):**

```text
-- BEFORE
request_id  topic       preferred_date  preferred_time  status
----------  ----------  --------------  --------------  ------
2           SQL SELECT  2026-11-13      15:30           Open

-- AFTER
request_id  topic                preferred_date  preferred_time  status
----------  -------------------  --------------  --------------  ------
2           SQL SELECT and JOIN  2026-11-14      16:00           Open
```

**Avery's Cancelled status:**

```text
request_id  student_name  topic        status
----------  ------------  -----------  ---------
3           Avery Patel   SQLite CRUD  Cancelled
```

**Why is a specific WHERE clause essential in an UPDATE statement?**
The `WHERE` clause limits the change to the intended row. Without it, the `SET` values would be applied to every row in the table. Using `WHERE request_id = ...` ensures only one request changes.

**Why does the Peer Tutoring Hub use a Cancelled status instead of immediately deleting a real request?**
Marking a request as `Cancelled` keeps the record, so there is still a history of what the student asked for and when it was cancelled. Tutors and staff can still see it, and it can be reviewed or reversed if the cancellation was a mistake. A `DELETE` permanently removes the data and cannot easily be undone.

## Part 5: Delete one test request

**INSERT statement for the test request:**

```sql
INSERT INTO tutoring_requests (student_id, course, topic, preferred_date, preferred_time)
VALUES (1, 'IS 6465', 'Delete Practice', '2026-11-20', '09:00');  -- became request_id 4
```

**DELETE statement:**

```sql
DELETE FROM tutoring_requests
WHERE request_id = 4;
```

**Verification output:**

```text
-- BEFORE the delete
request_id  student_id  topic                status
----------  ----------  -------------------  ---------
1           1           Forms                Open
2           1           SQL SELECT and JOIN  Open
3           2           SQLite CRUD          Cancelled
4           1           Delete Practice      Open

-- AFTER the delete (test record gone, other requests remain)
request_id  student_id  topic                status
----------  ----------  -------------------  ---------
1           1           Forms                Open
2           1           SQL SELECT and JOIN  Open
3           2           SQLite CRUD          Cancelled
```

**Why is a WHERE clause essential in a DELETE statement?**
`DELETE` removes whole rows. The `WHERE` clause identifies which row to remove. Without it, every row in the table would be deleted. Using `WHERE request_id = 4` removed only the test record.

## Part 6: Reflect on the CRUD workflow

| CRUD action | SQL statement used in this lab | Peer Tutoring Hub example |
|---|---|---|
| Create | `INSERT INTO` | Adding Jordan's "Forms" request: `INSERT INTO tutoring_requests (...) VALUES (1, 'IS 6465', 'Forms', ...)` |
| Read | `SELECT` (with `WHERE` and `JOIN`) | Listing every request with the student's name and email using `JOIN ... ORDER BY preferred_date` |
| Update | `UPDATE` | Changing request 2's topic, date and time, and setting Avery's request 3 to `Cancelled` |
| Delete | `DELETE` | Removing the "Delete Practice" test request with `DELETE FROM tutoring_requests WHERE request_id = 4` |

**1. How does the database preserve the connection between a student and that student's requests?**
Each request stores the `student_id` of the student who submitted it. That column is a foreign key referencing `students(student_id)`, so the request is always tied to a student row, and a JOIN on those columns brings the two back together.

**2. Which database constraint prevents two student rows from using the same email address?**
The `UNIQUE` constraint on `students.student_email`.

**3. What could happen if an UPDATE or DELETE statement did not include a WHERE clause?**
An `UPDATE` without `WHERE` would change every row in the table (for example, cancelling or rescheduling every request). A `DELETE` without `WHERE` would remove every row. Either would cause widespread data loss or corruption.

**4. When the application later receives values from an HTML form, why should PHP send those values as parameters instead of placing them directly into SQL text?**
Parameters (prepared statements) keep user input separate from the SQL command, so the database treats the values only as data and never as SQL code. This prevents SQL injection, where a user types SQL into a form field to read, change or delete data. It also handles quotes and special characters correctly.
