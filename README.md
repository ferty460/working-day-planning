# working-day-planning
course work at a technical school :(

# Database

    working-day-planning

    - User
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        password VARCHAR(255),
        email VARCHAR(255)
    );

    - Folder
    CREATE TABLE folders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme VARCHAR(255),
        description TEXT,
        user INT NULL,
        FOREIGN KEY (user) REFERENCES users(id)
    );
    
    - Task
    CREATE TABLE tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        description TEXT,
        status BOOLEAN,
        priority VARCHAR(255),
        date DATE,
        user_id INT NULL,
        folder INT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (folder) REFERENCES folders(id)
    );

    - Subtask
    CREATE TABLE subtasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme VARCHAR(255),
        description TEXT,
        is_completed BOOLEAN,
        date_completed DATE NULL,
        task INT NULL,
        FOREIGN KEY (task) REFERENCES tasks(id)
    );