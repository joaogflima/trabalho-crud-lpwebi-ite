-- Inserindo status padronizados
INSERT INTO status (nome) VALUES
('Aberto'),
('Em andamento'),
('Resolvido'),
('Fechado'),
('Pendente'),
('Em análise'),
('Concluído'),
('Cancelado');

-- Inserindo usuários fictícios com função
INSERT INTO usuarios (nome, login, senha, email, funcao) VALUES
('João da Silva', 'joaos', 'senha123', 'joao.silva@email.com', 'Solicitante'),
('Maria Oliveira', 'mariao', 'senha123', 'maria.oliveira@email.com', 'Atendente'),
('Carlos Souza', 'carloss', 'senha123', 'carlos.souza@email.com', 'Administrador'),
('Ana Pereira', 'anap', 'senha123', 'ana.pereira@email.com', 'Solicitante'),
('Bruno Lima', 'brunol', 'senha123', 'bruno.lima@email.com', 'Atendente'),
('Fernanda Rocha', 'fernandar', 'senha123', 'fernanda.rocha@email.com', 'Solicitante'),
('Diego Alves', 'diegoa', 'senha123', 'diego.alves@email.com', 'Administrador'),
('Luciana Martins', 'lucianam', 'senha123', 'luciana.martins@email.com', 'Solicitante'),
('Pedro Henrique', 'pedroh', 'senha123', 'pedro.henrique@email.com', 'Atendente'),
('Juliana Costa', 'julianac', 'senha123', 'juliana.costa@email.com', 'Solicitante'),
('Rafael Torres', 'rafaelt', 'senha123', 'rafael.torres@email.com', 'Solicitante');

-- Resetar Auto Increment (opcional)
ALTER TABLE incidentes AUTO_INCREMENT = 1;
ALTER TABLE requisicoes AUTO_INCREMENT = 1;

-- Inserindo incidentes fictícios
INSERT INTO incidentes (titulo, descricao, status, prioridade, criado_por) VALUES
('Erro no sistema de e-mail', 'Descrição automática do incidente 1.', 4, 'Média', 4),
('Impressora não funciona', 'Descrição automática do incidente 2.', 1, 'Alta', 7),
('Sistema de ponto caiu', 'Descrição automática do incidente 3.', 3, 'Alta', 2),
('Falha no acesso à internet', 'Descrição automática do incidente 4.', 3, 'Alta', 7),
('Aplicativo trava constantemente', 'Descrição automática do incidente 5.', 2, 'Alta', 8),
('Erro ao abrir planilhas', 'Descrição automática do incidente 6.', 4, 'Baixa', 8),
('Sistema de RH fora do ar', 'Descrição automática do incidente 7.', 3, 'Crítica', 3),
('Backup não foi concluído', 'Descrição automática do incidente 8.', 1, 'Crítica', 6),
('Falha na VPN corporativa', 'Descrição automática do incidente 9.', 2, 'Baixa', 10),
('Monitor com tela preta', 'Descrição automática do incidente 10.', 3, 'Crítica', 1),
('Teclado parou de funcionar', 'Descrição automática do incidente 11.', 2, 'Alta', 11);

-- Inserindo requisições fictícias
INSERT INTO requisicoes (titulo, descricao, tipo, status, criado_por) VALUES
('Solicitação de acesso ao sistema financeiro', 'Descrição automática da requisição 1.', 'Software', 6, 5),
('Pedido de notebook novo', 'Descrição automática da requisição 2.', 'Software', 5, 6),
('Instalação de Adobe Photoshop', 'Descrição automática da requisição 3.', 'Software', 8, 6),
('Criação de e-mail institucional', 'Descrição automática da requisição 4.', 'Acesso', 8, 2),
('Aumento de armazenamento no OneDrive', 'Descrição automática da requisição 5.', 'Acesso', 5, 4),
('Troca de monitor 24 polegadas', 'Descrição automática da requisição 6.', 'Hardware', 6, 6),
('Instalação do Microsoft Project', 'Descrição automática da requisição 7.', 'Software', 7, 2),
('Acesso ao repositório Git', 'Descrição automática da requisição 8.', 'Software', 6, 11),
('Atualização de licença do antivírus', 'Descrição automática da requisição 9.', 'Software', 5, 8),
('Cadastro em grupo do Teams', 'Descrição automática da requisição 10.', 'Software', 6, 9),
('Instalação de Java JDK', 'Descrição automática da requisição 11.', 'Software', 8, 5);