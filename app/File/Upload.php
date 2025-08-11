<?php

namespace App\File;

class Upload{
    /**
     * Mapeamento dos códigos de erro do upload de arquivos em PHP
     * @var array<int,string>
     */
    private const PHP_FILE_UPLOAD_ERRORS = [        
        1 => 'O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini',
        2 => 'O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML',
        3 => 'O upload do arquivo foi feito parcialmente',
        4 => 'Nenhum arquivo foi enviado',
        6 => 'Pasta temporária ausente',
        7 => 'Falha ao escrever o arquivo no disco',
        8 => 'Valor: 8; Uma extensão do PHP interrompeu o upload do arquivo'
    ];

    /**
     * Nome do arquivo (sem extensão)
     * @var string
     */
    private $name;

    /**
     * Extensão do arquivo (sem ponto)
     * @var string
     */
    private $extension;
    
    /**
     * Type do arquivo
     * @var string
     */
    private $type;

    /**
     * Nome temporário/Caminho temporário do arquivo
     * @var string
     */
    private $tmpName;
    
    /**
     * Código de erro do upload
     * @var integer
     */
    private $error;
    
    /**
     * Tamanho do arquivo
     * @var integer
     */
    private $size;    

    /**
     * Contador de duplicação de arquivo
     * @var integer
     */
    private $duplicates = 0;

    /**
     * Construtor da classe
     * @param array $file $_FILES['campo']
     */
    public function __construct($file){
        $info = pathinfo($file['name']);
        $this->name      = $info['filename']  ?? '';
        $this->extension = $info['extension'] ?? '';
        $this->type      = $file['type']      ?? '';
        $this->tmpName   = $file['tmp_name']  ?? '';
        $this->error     = $file['error'];
        $this->size      = $file['size'];
    }
    
    /**
     * Método responsável por alterar o nome do arquivo
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * Método responsável por gerar um novo nome aleatório
     */
    public function generateNewName(){
        $this->name = time().'-'.rand(100000, 999999).'-'.uniqid();
    }

    /**
     * Método responsável por retornar o nome do arquivo com sua extensão
     * @return string
     */
    public function getBasename(){
        // VALIDA EXTENSÃO
        $extension = strlen($this->extension) ? '.'.$this->extension : '';

        // VALIDA DUPLICAÇÃO
        $duplicates = $this->duplicates > 0 ? '-'.$this->duplicates : '';

        // RETORNA O NOME COMPLETO
        return $this->name.$duplicates.$extension;
    }
    /**
     * Método responsável por obter um nome possível para o arquivo
     * @param string $dir
     * @param boolean $overwrite
     * @return string
     */
    private function getPossibleBasename($dir, $overwrite){
        // SOBRESCREVER ARQUIVO
        if($overwrite) return $this->getBasename();

        // NÃO PODE SOBRESCREVER ARQUIVO
        $basename = $this->getBasename();

        // VERIFICAR DUPLICAÇÃO
        if(!file_exists($dir.'/'.$basename)){
            return $basename;
        }

        // INCREMENTAR DUPLICAÇÕES
        $this->duplicates++;

        // RETORNA O PRÓPRIO MÉTODO
        return $this->getPossibleBasename($dir, $overwrite);
    }

    /**
     * Método responsável por mover o arquivo de upload
     * @param string $dir
     * @param boolean $overwrite
     * @return boolean
     */
    public function upload($dir, $overwrite = true){
        // VERFICAR ERRO
        $arraySucesso = $this->hasUploadErrors();
        
        if($arraySucesso['status']){
            // ALTERA O NOME DO ARQUIVO - NOME FIXO
            // $this->setName('novo-arquivo-com-nome-alterado');
            
            // GERA UM NOME ALEATÓRIO
            $this->generateNewName();
            
            // CAMINHO COMPLETO DE DESTINO
            $path = $dir.'/'.$this->getPossibleBasename($dir, $overwrite);
            
            // MOVE O ARQUIVO PARA A PASTA DE DESTINO
            move_uploaded_file($this->tmpName, $path);
        }
        
        return $arraySucesso;
    }

    /**
     * Método responsável po criar instâncias de upload para multiplos arquivos 
     * @param array $files $_FILES['campo']
     * @return array
     */
    public static function createMultiUpload($files){
        $uploads = [];
        
        foreach($files['name'] as $key => $value){
            if(empty($value)){
                continue;
            }
            
            // ARRAY DE ARQUIVO
            $file = [
                'name'     => $files['name'][$key],
                'type'     => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error'    => $files['error'][$key],
                'size'     => $files['size'][$key]
            ];
            
            // NOVA INSTANCIA
            $uploads[] = new Upload($file);
        }
        
        return $uploads;
    }
    
    /**
     * Método responsável por verificar se há erros no envio do arquivo
     * @return array
     */
    private function hasUploadErrors(){
        $errorMessage = $this->getUploadErrorMessage($this->error);
        
        return [
            'status' => empty($errorMessage) ? true : false,
            'mensagem' => $errorMessage
        ];
    }

    /**
     * Método responsável por retorna o tipo do erro ao enviar um arquivo
     * @param int $code
     * @return string
     */
    public function getUploadErrorMessage(int $code): string {
        return self::PHP_FILE_UPLOAD_ERRORS[$code] ?? '';
    }
}