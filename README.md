# working-day-planning
course work at a technical school :(

# Database

    # working-day-planning

    - Subtask
    CREATE TABLE subtask (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme VARCHAR(255),
        description TEXT
    );
    
    - Task
    CREATE TABLE task (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        description TEXT,
        status BOOLEAN,
        priority VARCHAR(255),
        subtask INT NULL,
        FOREIGN KEY (subtask) REFERENCES subtask(id)
    );

    - Folder
    CREATE TABLE folder (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme VARCHAR(255),
        description TEXT,
        task INT NULL,
        FOREIGN KEY (task) REFERENCES task(id)
    );

    - User
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        password VARCHAR(255),
        folder INT NULL,
        FOREIGN KEY (folder) REFERENCES folder(id)
    );