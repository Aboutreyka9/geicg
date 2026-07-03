<?php

namespace App\Services;

use App\Core\Auth;
use DateTime;
use IntlDateFormatter;
use Roles;

class dCatalogueService
{
    public static function aModalAddCategorie()
    {
        return '
        <form action="" id="frmAddCategorie" method="POST">
                  <div class="form-group">
                      <label for="libelle_categorie">Libelle <span class="text-danger">*</span> </label>
                      <input name="libelle_categorie" type="text" class="form-control"  id="libelle_categorie" >
                  </div>

                  <div class="form-group">
                  <input value="btn_ajouter_categorie" name="action" type="hidden">
                    <label for="description_categorie">Description (200 Caractères)</label>
                    <textarea name="description_categorie" value="" rows="4"  maxlength="250" class="form-control"></textarea>
                  </div>
                    <button type="submit" id="btn_add_categorie" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>
              </form>
        ';
    }

    public static function modalUpdateCategorie($categorie)
    {
        return '
        <form action="" id="frmAddCategorie" method="POST">
                <div class="form-group">
                    <label for="libelle_categorie">Libelle <span class="text-danger">*</span>  </label>
                    <input name="libelle_categorie" type="text" class="form-control" value="' . $categorie['libelle_categorie'] . '" id="libelle_categorie" >
                </div>

                <div class="form-group">
                    <label for="description_categorie">Description (200 Caractères)</label>
                    <textarea name="description_categorie" rows="4"  maxlength="250" class="form-control">' . $categorie['description_categorie'] . '</textarea>
                    <input name="code_categorie" value="' . ($categorie['code_categorie']) . '" type="hidden">
                    <input name="action" value="btn_modifier_categorie" type="hidden">
                </div>
                        <button type="submit" id="btn_add_categorie" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>

            </form>
        ';
    }

    public static function aModalAddMark()
    {
        return '
        <form action="" id="frmAddMark" method="POST">
                  <div class="form-group">
                      <label for="libelle_mark">Libelle <span class="text-danger">*</span> </label>
                      <input name="libelle_mark" type="text" class="form-control"  id="libelle_mark" >
                  </div>

                  <div class="form-group">
                  <input value="btn_ajouter_mark" name="action" type="hidden">
                  </div>
                    <button type="submit" id="btn_add_mark" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>
              </form>
        ';
    }

    public static function modalUpdateMark($mark)
    {
        return '
        <form action="" id="frmAddMark" method="POST">
                <div class="form-group">
                    <label for="libelle_mark">Libelle <span class="text-danger">*</span>  </label>
                    <input name="libelle_mark" type="text" class="form-control" value="' . $mark['libelle_mark'] . '" id="libelle_mark" >
                </div>

                <div class="form-group">
                    <input name="code_mark" value="' . ($mark['code_mark']) . '" type="hidden">
                    <input name="action" value="btn_modifier_mark" type="hidden">
                </div>
                        <button type="submit" id="btn_add_mark" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>

            </form>
        ';
    }
    public static function aModalAddUnite()
    {
        return '
        <form action="" id="frmAddUnite" method="POST">
                  <div class="form-group">
                      <label for="libelle_unite">Libelle <span class="text-danger">*</span> </label>
                      <input name="libelle_unite" type="text" class="form-control"  id="libelle_unite" >
                  </div>

                  <div class="form-group">
                  <input value="btn_ajouter_unite" name="action" type="hidden">
                  </div>
                    <button type="submit" id="btn_add_unite" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>
              </form>
        ';
    }

    public static function modalUpdateUnite($unite)
    {
        return '
        <form action="" id="frmAddUnite" method="POST">
                <div class="form-group">
                    <label for="libelle_unite">Libelle <span class="text-danger">*</span>  </label>
                    <input name="libelle_unite" type="text" class="form-control" value="' . $unite['libelle_unite'] . '" id="libelle_unite" >
                </div>

                <div class="form-group">
                    <input name="code_unite" value="' . ($unite['code_unite']) . '" type="hidden">
                    <input name="action" value="btn_modifier_unite" type="hidden">
                </div>
                        <button type="submit" id="btn_add_unite" class="btn btn-primary modal_footer"> <i class="fa fa-check-circle"></i> Enregistrer </button>

            </form>
        ';
    }

    public static function aModalAddProduit($categories, $marks, $unites)
    {
        return '
    <form action="" id="frmAddProduit" method="POST">

        <div class="form-group">
            <label>Libellé produit <span class="text-danger">*</span></label>
            <input type="text" name="libelle_produit" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Code barre</label>
            <input type="text" name="code_bar" class="form-control">
        </div>

        

        <div class="form-group">
            <label>Prix achat</label>
            <input type="number" step="0.01" name="prix_achat" class="form-control">
        </div>

        <div class="form-group">
            <label>Prix vente</label>
            <input type="number" step="0.01" name="prix_vente" class="form-control">
        </div>

        <div class="form-group">
            <label>Garantie (mois)</label>
            <input type="number" name="garantie_produit" class="form-control">
        </div>

        <div class="form-group">
            <label>Stock initial</label>
            <input type="number" name="stock_produit" class="form-control">
        </div>

        <input type="hidden" name="boutique_code" value="' . BOUTIQUE_CODE . '">
        <input type="hidden" name="compte_code" value="' . COMPTE_CODE . '">
        <input type="hidden" name="action" value="btn_ajouter_produit">

        <button type="submit" class="btn btn-primary modal_footer">
            <i class="fa fa-check-circle"></i> Enregistrer
        </button>

    </form>';
    }

    public static function modalUpdateProduit($produit, $categories, $marks, $unites)
    {
        return '
    <form action="" id="frmUpdateProduit" method="POST">

        <div class="row">
        <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '">
        <div class="col-md-6 form-group">
            <label>Libellé produit</label>
            <input type="text" name="libelle_produit" value="' . $produit['libelle_produit'] . '" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label>Code barre</label>
            <input type="text" name="code_bar" value="' . $produit['code_bar'] . '" class="form-control">
        </div>
        </div>
        <div class="row">

        <div class="col-md-4 form-group">
            <label>Catégorie</label>
            <select name="categorie_code" class="form-control">';
        foreach ($categories as $cat) {

            $form .= '<option value="' . $cat['code_categorie'] . '" ' . $selected . '>' . $cat['libelle_categorie'] . '</option>';
        }
        $form .= '
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>Marque</label>
            <select name="mark_code" class="form-control">';
        foreach ($marks as $mark) {
            $selected = ($mark['code_mark'] == $produit['mark_code']) ? 'selected' : '';
            $form .= '<option value="' . $mark['code_mark'] . '" ' . $selected . '>' . $mark['libelle_mark'] . '</option>';
        }
        $form .= '
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>Unité</label>
            <select name="unite_code" class="form-control">';
        foreach ($unites as $unite) {
            $selected = ($unite['code_unite'] == $produit['unite_code']) ? 'selected' : '';
            $form .= '<option value="' . $unite['code_unite'] . '" ' . $selected . '>' . $unite['libelle_unite'] . '</option>';
        }
        $form .= '
            </select>
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 form-group">
            <label>Prix achat</label>
            <input type="number" step="0.01" name="prix_achat" value="' . $produit['prix_achat'] . '" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label>Prix vente</label>
            <input type="number" step="0.01" name="prix_vente" value="' . $produit['prix_vente'] . '" class="form-control">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 form-group">
            <label>Garantie (mois)</label>
            <input type="number" name="garantie_produit" value="' . $produit['garantie_produit'] . '" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label>Stock</label>
            <input type="number" name="stock_produit" value="' . $produit['stock_produit'] . '" class="form-control">
        </div>
        </div>

        <input type="hidden" name="code_produit" value="' . $produit['code_produit'] . '">
        <input type="hidden" name="action" value="btn_modifier_produit">

        <button type="submit" class="btn btn-primary modal_footer">
            <i class="fa fa-check-circle"></i> Modifier
        </button>

    </form>';
    }
}
