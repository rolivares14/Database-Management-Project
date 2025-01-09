-- Table for Professors
CREATE TABLE Professors (
    ssn VARCHAR(11) PRIMARY KEY,
    name VARCHAR(100),
    address_street VARCHAR(255),
    address_city VARCHAR(100),
    address_state VARCHAR(50),
    address_zip VARCHAR(10),
    telephone_area_code VARCHAR(5),
    telephone_number VARCHAR(10),
    sex CHAR(1),
    title VARCHAR(50),
    salary DECIMAL(10, 2),
    degrees VARCHAR(255)
);

-- Table for Departments
CREATE TABLE Departments (
    department_number INT PRIMARY KEY,
    name VARCHAR(100),
    telephone VARCHAR(15),
    office_location VARCHAR(255),
    chairperson_ssn VARCHAR(11),
    FOREIGN KEY (chairperson_ssn) REFERENCES Professors(ssn)
);

-- Table for Courses
CREATE TABLE Courses (
    course_number INT PRIMARY KEY,
    title VARCHAR(100),
    textbook VARCHAR(255),
    units INT,
    department_number INT,
    FOREIGN KEY (department_number) REFERENCES Departments(department_number)
);

-- Table for Prerequisite Courses
CREATE TABLE Prerequisites (
    course_number INT,
    prerequisite_course_number INT,
    PRIMARY KEY (course_number, prerequisite_course_number),
    FOREIGN KEY (course_number) REFERENCES Courses(course_number),
    FOREIGN KEY (prerequisite_course_number) REFERENCES Courses(course_number)
);

-- Table for Course Sections
CREATE TABLE Sections (
    section_number INT PRIMARY KEY,
    course_number INT,
    classroom VARCHAR(50),
    seats INT,
    meeting_days VARCHAR(20),
    start_time TIME,
    end_time TIME,
    professor_ssn VARCHAR(11),
    FOREIGN KEY (course_number) REFERENCES Courses(course_number),
    FOREIGN KEY (professor_ssn) REFERENCES Professors(ssn)
);

-- Table for Students
CREATE TABLE Students (
    campus_id INT PRIMARY KEY,
    name_first VARCHAR(50),
    name_last VARCHAR(50),
    address VARCHAR(255),
    telephone VARCHAR(15),
    major_department_number INT,
    FOREIGN KEY (major_department_number) REFERENCES Departments(department_number)
);

-- Table for Student Minors
CREATE TABLE StudentMinors (
    campus_id INT,
    minor_department_number INT,
    PRIMARY KEY (campus_id, minor_department_number),
    FOREIGN KEY (campus_id) REFERENCES Students(campus_id),
    FOREIGN KEY (minor_department_number) REFERENCES Departments(department_number)
);

-- Table for Enrollment Records
CREATE TABLE Enrollments (
    enrollment_id INT PRIMARY KEY,
    student_campus_id INT,
    section_number INT,
    grade VARCHAR(2),
    FOREIGN KEY (student_campus_id) REFERENCES Students(campus_id),
    FOREIGN KEY (section_number) REFERENCES Sections(section_number)
);
