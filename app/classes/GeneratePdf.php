<?php

namespace app\classes;

use FPDF;

class GeneratePdf extends FPDF
{
	public function Header()
	{
		$this->SetFont('Arial', 'B', 15);
		$this->Cell(0, 10, 'Relatorio de Funcionarios', 0, 1, 'C');
		$this->Ln(10);
	}

	public function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
	}

	private function formataMoeda($valor)
	{
		return 'R$ ' . number_format($valor, 2, ',', '.');
	}

	private function formataData($data)
	{
		return date('d/m/Y', strtotime($data));
	}

	public function gerarRelatorio($dados)
	{
		$this->AddPage();
		$this->SetFont('Arial', '', 12);

		foreach ($dados as $funcionario) {
			$this->SetDrawColor(200, 200, 200);
			$this->Line(10, $this->GetY(), 200, $this->GetY());
			$this->Ln(5);

			$this->SetFont('Arial', 'B', 12);
			$this->Cell(0, 7, $funcionario->nome, 0, 1);

			$this->SetFont('Arial', '', 11);
			$this->Cell(30, 7, 'Empresa:', 0, 0);
			$this->Cell(0, 7, $funcionario->nome_empresa, 0, 1);

			$this->Cell(30, 7, 'Email:', 0, 0);
			$this->Cell(0, 7, $funcionario->email, 0, 1);

			$this->Cell(30, 7, 'Cadastro:', 0, 0);
			$this->Cell(0, 7, $this->formataData($funcionario->data_cadastro), 0, 1);

			$this->Cell(30, 7, 'Salario:', 0, 0);
			$this->Cell(0, 7, $this->formataMoeda($funcionario->salario), 0, 1);

			$this->Cell(30, 7, 'Bonificacao:', 0, 0);
			$this->Cell(0, 7, $this->formataMoeda($funcionario->bonificacao), 0, 1);

			$this->Ln(5);

			if ($this->GetY() > 250) {
				$this->AddPage();
			}
		}
	}

	public static function criarPDF($dados, $nomeArquivo = 'relatorio.pdf')
	{
		try {
			$pdf = new self();
			$pdf->gerarRelatorio($dados);
			$pdf->Output('F', $nomeArquivo);
			return true;
		} catch (\Exception $e) {
			return "Erro ao gerar PDF: " . $e->getMessage();
		}
	}
}
