# working-day-planning
course work at a technical school :(

# Database

    working-day-planning

    - User
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        surname VARCHAR(255),
        lastname VARCHAR(255) NULL,
        password VARCHAR(255),
        email VARCHAR(255),
        role ENUM('user', 'admin'),
        employer_id INT NULL,
        FOREIGN KEY (employer_id) REFERENCES users(id)
    );

    - Group
    CREATE TABLE groups (
        id INT AUTO_INCREMENT PRIMARY KEY,
        theme VARCHAR(255),
        description TEXT,
        user INT NULL,
        FOREIGN KEY (user) REFERENCES users(id)
    );

    - UserGroup
    CREATE TABLE users_groups (
        user_id INT,
        group_id INT,
        PRIMARY KEY (user_id, group_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (group_id) REFERENCES groups(id)
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
        role ENUM('home', 'work'),
        user_id INT NULL,
        folder INT NULL,
        employer INT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (folder) REFERENCES folders(id),
        FOREIGN KEY (employer) REFERENCES users(id)
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