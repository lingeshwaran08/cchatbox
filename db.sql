CREATE TABLE categories (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE subcategories (
    id VARCHAR(50) PRIMARY KEY,
    category_id VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE options (
    id VARCHAR(50) PRIMARY KEY,
    subcategory_id VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(id) ON DELETE CASCADE
);

CREATE TABLE answers (
    id VARCHAR(50) PRIMARY KEY,
    option_id VARCHAR(50) NOT NULL,
    answer_text TEXT NOT NULL,
    FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE CASCADE
);


