export const vertexShader = `
    uniform float u_time;
    attribute float speed;
    void main() {
        vec3 pos = position;
        pos.y = sin(pos.x * 0.2 + u_time * speed) * 5.0;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(pos, 1.0);
        gl_PointSize = 2.0;
    }
`;

export const fragmentShader = `
    uniform vec3 u_color;
    void main() {
        float distance = length(gl_PointCoord - vec2(0.5));
        if (distance > 0.5) discard;
        gl_FragColor = vec4(u_color, 1.0 - distance * 2.0);
    }
`;
