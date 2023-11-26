import React, { useState } from "react";
import { Button, TextField, Typography, Container, Paper } from "@mui/material";

interface RegisterProps {
  onRegister: (username: string, password: string) => void;
}

const Register: React.FC<RegisterProps> = ({ onRegister }) => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  const handleRegister = () => {
    // Validasi input atau logika registrasi lainnya
    onRegister(username, password);
  };

  return (
    <Container component="main" maxWidth="xs">
      <Paper
        elevation={3}
        sx={{
          padding: 4,
          display: "flex",
          flexDirection: "column",
          alignItems: "center",
        }}
      >
        <Typography component="h1" variant="h5">
          Register
        </Typography>
        <TextField
          margin="normal"
          required
          fullWidth
          label="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
        <TextField
          margin="normal"
          required
          fullWidth
          label="Password"
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <Button
          variant="contained"
          color="primary"
          onClick={handleRegister}
          fullWidth
        >
          Register
        </Button>
      </Paper>
    </Container>
  );
};

export default Register;
