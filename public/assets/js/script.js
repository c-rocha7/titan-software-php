const applyCurrencyMask = (value) => {
  const numericValue = value.replace(/\D/g, "");
  const formattedValue = (numericValue / 100).toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL",
  });
  return formattedValue.replace("R$", "").trim();
};
