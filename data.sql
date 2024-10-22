CREATE TABLE Veterinarians (
    VetID INT AUTO_INCREMENT PRIMARY KEY,
    VetName VARCHAR(100) NOT NULL
);

CREATE TABLE Appointments (
    AppointmentID INT AUTO_INCREMENT PRIMARY KEY,
    VetID INT,
    PetName VARCHAR(100) NOT NULL,
    OwnerName VARCHAR(100) NOT NULL,
    AppointmentDate DATE NOT NULL,
    AppointmentTime TIME NOT NULL
);
