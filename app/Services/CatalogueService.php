<?php

namespace App\Services;

use App\Core\Auth;
use App\Models\Catalogue;
use App\Models\Factory;
use DateTime;
use IntlDateFormatter;
use Roles;

class CatalogueService
{

    public static function categorieDataService($categories)
    {
        $data = [];

        $i = 0;
        foreach ($categories as $categorie) :
            $i++;
            $data[] = [
                $i,
                $categorie['libelle_categorie'],
                $categorie['description_categorie'],
                '
                <div class="table_button">

                <button
            id="frmModifierCategorie' . $i . '"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierCategorie"
            data-categorie="' . ($categorie['code_categorie']) . '">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="categorieDeleteCategorie' . $i . '"
            type="button"
            class="btn btn-danger btn-sm categorieDeleteCategorie"
            data-categorie="' . $categorie['code_categorie'] . '">
            <i class="fa fa-trash"></i> Supprimer
          </button>

                </div>
               '
            ];

        endforeach;

        return $data;
    }

    public static function markDataService($marks)
    {
        $data = [];

        $i = 0;
        foreach ($marks as $mark) :
            $i++;
            $data[] = [
                $i,
                $mark['libelle_mark'],
                '
                <div class="table_button">

                <button
            id="frmModifiermark' . $i . '"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierMark"
            data-mark="' . ($mark['code_mark']) . '">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="markDeleteMark' . $i . '"
            type="button"
            class="btn btn-danger btn-sm markDeleteMark"
            data-mark="' . $mark['code_mark'] . '">
            <i class="fa fa-trash"></i> Supprimer
          </button>

                </div>
               '
            ];

        endforeach;

        return $data;
    }

    public static function uniteDataService($unites)
    {
        $data = [];

        $i = 0;
        foreach ($unites as $unite) :
            $i++;
            $data[] = [
                $i,
                $unite['libelle_unite'],
                '
                <div class="table_button">

                <button
            id="frmModifierUnite' . $i . '"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierUnite"
            data-unite="' . ($unite['code_unite']) . '">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="uniteDeleteUnite' . $i . '"
            type="button"
            class="btn btn-danger btn-sm uniteDeleteUnite"
            data-unite="' . $unite['code_unite'] . '">
            <i class="fa fa-trash"></i> Supprimer
          </button>

                </div>
               '
            ];

        endforeach;

        return $data;
    }

    public static function produitDataService($produits)
    {
        $data = [];

        $i = 0;
        foreach ($produits as $produit) :
            $i++;
            $data[] = [
                $i,
                $produit['libelle_produit'],
                $produit['libelle_mark'],
                $produit['libelle_categorie'],
                $produit['prix_achat'],
                $produit['prix_vente'],
                $produit['stock_produit'],
                '
                <div class="table_button">

                <button
            id="frmModifierProduit' . $i . '"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierProduit"
            data-produit="' . ($produit['code_produit']) . '">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="produitDeleteProduit' . $i . '"
            type="button"
            class="btn btn-danger btn-sm produitDeleteProduit"
            data-produit="' . $produit['code_produit'] . '">
            <i class="fa fa-trash"></i> Supprimer
          </button>

                </div>
               '
            ];

        endforeach;

        return $data;
    }


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
        $form = '
    <form id="frmAddProduit" method="POST">

        <div class="row">
        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
            <div class="col-md-6 form-group">
                <label>Libellé produit <span class="text-danger">*</span></label>
                <input type="text" name="libelle_produit" placeholder="Exp:Savon" class="form-control" required>
            </div>
            <div class="col-md-6 form-group">
                <label>Code barre</label>
                <input type="text" name="code_bar" placeholder="Exp:166778888" class="form-control">
            </div>

        </div>
       <hr>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Catégorie</label>
                <select name="categorie_code" class="form-control">
                    <option value="">-- Sélectionner --</option>';

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $form .= '
                                <option value="' . $cat['code_categorie'] . '">
                                    ' . $cat['libelle_categorie'] . '
                                </option>';
            }
        }

        $form .= '
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label>Marque <span class="text-danger">*</span> </label>
                <select name="mark_code" class="form-control">
                    <option value="">-- Sélectionner --</option>';

        if (!empty($marks)) {
            foreach ($marks as $mark) {
                $form .= '
                            <option value="' . $mark['code_mark'] . '">
                                ' . $mark['libelle_mark'] . '
                            </option>';
            }
        }

        $form .= '
                </select>
            </div>
              <div class="col-md-4 form-group">
                <label>Unité <span class="text-danger">*</span></label>
                <select name="unite_code" class="form-control">
                    <option value="">-- Sélectionner --</option>';

        if (!empty($unites)) {
            foreach ($unites as $unite) {
                $form .= '
                                    <option value="' . $unite['code_unite'] . '">
                                        ' . $unite['libelle_unite'] . '
                                    </option>';
            }
        }

        $form .= '
                </select>
            </div>
        </div>
        <hr>
        <div class="row">
          
            <div class="col-md-6 form-group">
                <label>Prix achat <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="prix_achat" placeholder="Exp:50000" class="form-control">
            </div>

            <div class="col-md-6 form-group">
                <label>Prix vente <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="prix_vente" placeholder="Exp:55000" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Garantie (mois) <span class="text-danger">*</span> </label>
                <input type="number" name="garantie_produit" placeholder="Exp:1" class="form-control">
            </div>

            <div class="col-md-6 form-group">
                <label>Stock initial <span class="text-danger">*</span> </label>
                <input type="number" name="stock_produit" placeholder="Exp:500" class="form-control">
            </div>
        </div>

            
            <input type="hidden" name="action" value="btn_ajouter_produit">

            <button type="submit" class="btn btn-primary modal_footer">
                <i class="fa fa-check-circle"></i> Enregistrer
            </button>

    </form>';

        return $form;
    }

    public static function modalUpdateProduit($produit, $categories, $marks, $unites)
    {
        $form = '';
        $form .= '
        <form action="" id="frmUpdateProduit" method="POST">

            <div class="row">
                <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '">
                <div class="col-md-6 form-group">
                    <label>Libellé produit</label>
                    <input type="text" name="libelle_produit" value="' . $produit['libelle_produit'] . '"
                        class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Code barre</label>
                    <input type="text" name="code_bar" value="' . $produit['code_bar'] . '" class="form-control">
                </div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-4 form-group">
                    <label>Catégorie</label>
                    <select name="categorie_code" class="form-control">
                        <option value="">-- Sélectionner --</option>';

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $form .= '
                        <option ' . selected($cat['code_categorie'], $produit['categorie_code']) . ' value="' . $cat['code_categorie'] . '">
                            ' . $cat['libelle_categorie'] . '
                        </option>';
            }
        }

        $form .= '
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Marque <span class="text-danger">*</span> </label>
                    <select name="mark_code" class="form-control">
                        <option value="">-- Sélectionner --</option>';

        if (!empty($marks)) {
            foreach ($marks as $mark) {
                $form .= '
                        <option ' . selected($mark['code_mark'], $produit['mark_code']) . ' value="' . $mark['code_mark'] . '">
                            ' . $mark['libelle_mark'] . '
                        </option>';
            }
        }

        $form .= '
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Unité <span class="text-danger">*</span></label>
                    <select name="unite_code" class="form-control">
                        <option value="">-- Sélectionner --</option>';

        if (!empty($unites)) {
            foreach ($unites as $unite) {
                $form .= '
                        <option ' . selected($unite['code_unite'], $produit['unite_code']) . ' value="' . $unite['code_unite'] . '">
                            ' . $unite['libelle_unite'] . '
                        </option>';
            }
        }

        $form .= '
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Prix achat</label>
                    <input type="number" step="0.01" name="prix_achat" value="' . $produit['prix_achat'] . '"
                        class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Prix vente</label>
                    <input type="number" step="0.01" name="prix_vente" value="' . $produit['prix_vente'] . '"
                        class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Garantie (mois)</label>
                    <input type="number" name="garantie_produit" value="' . $produit['garantie_produit'] . '"
                        class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Stock</label>
                    <input type="number" name="stock_produit" value="' . $produit['stock_produit'] . '"
                        class="form-control">
                </div>
            </div>

            <input type="hidden" name="code_produit" value="' . $produit['code_produit'] . '">
            <input type="hidden" name="action" value="btn_modifier_produit">

            <button type="submit" class="btn btn-primary modal_footer">
                <i class="fa fa-check-circle"></i> Modifier
            </button>

        </form>';
        return $form;
    }
}
