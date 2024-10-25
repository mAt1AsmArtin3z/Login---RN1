import React, { useState } from 'react';
import { View, TextInput, Button, Text } from 'react-native';
import axios from 'axios';
import { useTheme } from 'react-native-paper';
import useStyles from './styles';

const Login = ({ navigation }) => {
    const [username, setUsername] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const styles = useStyles();

    const handleLogin = () => {
        axios.post('http://192.168.1.39/login.php', {
            username,
            email,
            password,
        })
        .then(response => {
            if (response.data.success) {
                navigation.navigate('Bienvenido');
            } else {
                alert('Error en el login: ' + response.data.message);
            }
        })
        .catch(error => {
            console.error(error);
            alert('Error en la conexión: ' + error.message);
        });
    };

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Iniciar Sesión</Text>
            <TextInput 
                style={styles.input} 
                placeholder="Usuario" 
                onChangeText={setUsername} 
            />
            <TextInput 
                style={styles.input} 
                placeholder="Email" 
                onChangeText={setEmail} 
                keyboardType="email-address" 
            />
            <TextInput 
                style={styles.input} 
                placeholder="Contraseña" 
                onChangeText={setPassword} 
                secureTextEntry 
            />
            <Button title="Iniciar Sesión" onPress={handleLogin} />
            <Text style={styles.registerLink} onPress={() => navigation.navigate('Register')}>
                ¿No tienes una cuenta? Regístrate aquí.
            </Text>
        </View>
    );
};

export default Login;